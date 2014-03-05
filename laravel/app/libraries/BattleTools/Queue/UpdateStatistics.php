<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use BattleTools\Util\ListSentence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatistics{

	public function fire($job, $data){
		$start = Carbon::now();
		Log::notice(count($data).' stats being processed.');

		if($job->attempts() > 1){
			Log::emergency('Adding statistics failed after '.Carbon::now()->diffInSeconds($start).' seconds.');
			$newData = Cache::get('newStatistics', function(){return array();});
			Cache::forever('newStatistics', $newData+$data);
			$job->delete();
		}

		foreach($data as $dataObject){
			$server = $dataObject['server'];
			$banned_server = DB::table('banned_server')->where('server', $server)->get();
			if(count($banned_server) == 0){
				$limitedKeys = Config::get('statistics.limited-keys');
				$allowedKeys = Config::get('statistics.tracked');
				$keys = $dataObject['keys'];
				$time = $dataObject['time'];

				foreach(array_keys($keys) as $key){
					$value = $keys[$key];

					if(ListSentence::startsWith($key, 'p')){
						$plugin = substr($key, 1);

						$pluginRequests = DB::table('plugin_statistics')
							->where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))
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
							->where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))
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
			}
		}

		$stop = Carbon::now()->diffInSeconds($start);
		Log::notice('Stats have finished processing. This took '.$stop.' seconds.');
		Cache::forever('lastUpdate', $stop);
		$job->delete();
	}
}
