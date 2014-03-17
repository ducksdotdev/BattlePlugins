<?php
namespace BattleTools\Queue;

use BattleTools\Util\ListSentence;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatistics{

	public function fire($job, $data){
//		$start = round(microtime(true) * 1000);
		$interval = Config::get('statistics.interval');

		$count = 0;
		$drop = 0;

		$data = Cache::get('newStatistics', array());
		Cache::forget('newStatistics');

		if($job->attempts() > 1){
			Log::emergency('Adding statistics failed.');
			Cache::put('newStatistics', $data, $interval);
			$job->delete();

			return;
		}

		$dataCount = count($data);

		if($dataCount == 0){
			$job->delete();

			return;
		}

		$sInserts = array();
		$pInserts = array();
		$dropped = array();

		$allowedKeys = Config::get('statistics.tracked');

		foreach($data as $dataObject){
			$server = $dataObject['server'];
			$banned_server = DB::table('banned_server')->where('server', $server)->get();
			if(count($banned_server) == 0){
				$keys = $dataObject['keys'];
				$time = $dataObject['time'];

				$pairs = array(
					'server'      => $server,
					'inserted_on' => $time
				);

				foreach(array_keys($keys) as $key){
					$value = $keys[$key];

					if(ListSentence::startsWith($key, 'p')){
						$plugin = substr($key, 1);
						$plugins = DB::table('plugins')->select('name')->where('name', $plugin)->get();

						if(count($plugins) > 0){
							$count++;
							$value = explode(',', $value);

							$version = $value[0];
							$played = count($value) > 1 ? $value[1] : 0;

							array_push($pInserts, array(
								'server'      => $server,
								'plugin'      => $plugin,
								'version'     => $version,
								'played'      => $played,
								'inserted_on' => $time
							));
						}else{
							$drop++;
							$dropped[] = $plugin.' v'.$value;
						}
					}else if(in_array($key, $allowedKeys)){
						$count++;
						$pairs[$key] = $value;
					}else{
						$drop++;
						$dropped[] = $value;
					}
				}

				$leftOver = array_diff($allowedKeys, array_keys($pairs));
				foreach($leftOver as $pair){
					$pairs[$pair] = null;
				}
			}
			array_push($sInserts, $pairs);
		}

		if(count($pInserts) > 0){
			DB::table('plugin_statistics')->insert($pInserts);
		}

		if(count($sInserts) > 0){
			DB::table('server_statistics')->insert($sInserts);
		}

		//		$waste = round($drop / ($drop + $count) * 100, 2);
		//		$stop = round(microtime(true) * 1000) - $start;
		//		Log::notice(count($sInserts) + count($pInserts).' new statistic requests handled ('.count($sInserts).' new plugin records, '.count($pInserts).' new server records). This took '.$stop.'ms to process. '.$count.' new pieces of data have been entered, '.$drop.' pieces of data have been dropped. '.$waste.'% of this request was dropped data.');
		$job->delete();
	}
}
