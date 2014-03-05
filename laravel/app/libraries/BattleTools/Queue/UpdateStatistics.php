<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use BattleTools\Util\ListSentence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatistics{

	public function fire($job, $data){
		if($job->attempts() > 1){
			Log::emergency(json_encode($data));
			$job->delete();
		}

		$diff = DateUtil::getTimeToThirty()->addMinutes(30);

		$limitedKeys = Cache::get('limitedKeys', function () use ($diff){
			$keys = Config::get('statistics.limited-keys');
			Cache::put('limitedKeys', $keys, $diff);

			return $keys;
		});

		$allowedKeys = Cache::get('allowedKeys', function () use ($diff){
			$keys = Config::get('statistics.tracked');
			Cache::put('alloweddKeys', $keys, $diff);

			return $keys;
		});

		$keys = $data['keys'];
		$server = $data['server'];
		$time = Carbon::now();

		foreach(array_keys($keys) as $key){
			$value = $keys[$key];

			if(ListSentence::startsWith($key, 'p')){
				$plugin = substr($key, 1);

				$pluginRequests = DB::table('plugin_statistics')
					->where('inserted_on', '>', DateUtil::getTimeToThirty())
					->where('server', $server)
					->where('plugin', $plugin)->get();

				$plugins = DB::table('plugins')->select('name')->where('name', $plugin)->get();

				if(count($pluginRequests) == 0 && count($plugins) > 0){
					DB::table('plugin_statistics')->insert(array(
						'server'      => $server,
						'plugin'      => $plugin,
						'version'     => $value,
						'inserted_on' => $time
					));
				}
			}else if(!in_array($key, $limitedKeys) && in_array($key, $allowedKeys)){
				$serverRequests = DB::table('server_statistics')
					->where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinute())
					->where('server', $server)
					->where('key', $key)
					->get();

				if(count($serverRequests) == 0){
					DB::table('server_statistics')->insert(array(
						'server'      => $server,
						'key'         => $key,
						'value'       => $value,
						'inserted_on' => $time
					));
				}
			}
		}

		$job->delete();
	}
}
