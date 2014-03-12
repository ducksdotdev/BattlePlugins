<?php
namespace BattleTools\Queue;

use BattleTools\Util\ListSentence;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatistics{

	public function fire($job, $data){
		$start = round(microtime(true) * 1000);

		$count = 0;
		$drop = 0;

		$data = Cache::get('newStatistics', array());
		Cache::forget('newStatistics');

		if($job->attempts() > 1){
			Log::emergency('Adding statistics failed.');
			Cache::put('newStatistics', $data, 30);
			$job->delete();

			return;
		}

		$dataCount = count($data);

		if($dataCount == 0){
			$timewaste = round(microtime(true) * 1000) - $start;
			Log::warning('No data, process stopped. This wasted '.$timewaste.'ms.');
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
							array_push($pInserts, array(
								'server'      => $server,
								'plugin'      => $plugin,
								'version'     => $value,
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
