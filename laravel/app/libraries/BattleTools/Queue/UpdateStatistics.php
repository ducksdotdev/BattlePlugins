<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use BattleTools\Util\ListSentence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class UpdateStatistics{

	public function fire($job, $data){

		if($job->attempts() > 3){
			Log::emergency(json_encode($data));
			$job->delete();
		}

		$limitedKeys = Config::get('statistics.limited-keys');
		$allowedKeys = Config::get('statistics.tracked');

		$keys = $data['keys'];
		$server = $data['server'];
		$time = Carbon::now();

		$pluginList = DB::table('plugins')->select('name')->get();

		$nameList = array();
		foreach($pluginList as $pluginName){
			$nameList[] = $pluginName->name;
		}
		$pluginList = $nameList;

		$pluginRequests = DB::table('plugin_statistics')
			->where('inserted_on', '<', DateUtil::getTimeToThirty())
			->where('server', $server)
			->select('plugin')->get();
		$pluginRList = array();
		foreach($pluginRequests as $request){
			$pluginRList[] = $request->plugin;
		}
		$pluginRequests = $pluginRList;

		$serverRequests = DB::table('server_statistics')
			->where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())
			->where('server', $server)
			->select('key')
			->get();
		$serverRList = array();
		foreach($serverRequests as $request){
			$serverRList[] = $request->key;
		}
		$serverRequests = $serverRList;

		foreach(array_keys($keys) as $key){
			$value = $keys[$key];

			if(ListSentence::startsWith($key, 'p')){
				$plugin = substr($key, 1);

				if(!in_array($plugin, $pluginRequests) && in_array($plugin, $pluginList)){
					DB::table('plugin_statistics')->insert(array(
						'server'      => $server,
						'plugin'      => $plugin,
						'version'     => $value,
						'inserted_on' => $time
					));
				}
			}else if(!in_array($key, $serverRequests) && !in_array($key, $limitedKeys) && in_array($key, $allowedKeys)){
				DB::table('server_statistics')->insert(array(
					'server'      => $server,
					'key'         => $key,
					'value'       => $value,
					'inserted_on' => $time
				));
			}
		}

		Log::notice(json_encode($data));
		$job->delete();
	}
}