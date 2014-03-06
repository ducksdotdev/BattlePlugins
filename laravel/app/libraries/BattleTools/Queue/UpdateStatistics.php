<?php
namespace BattleTools\Queue;

use BattleTools\Util\ListSentence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatistics{

	public function fire($job, $data){
		$start = Carbon::now();

		$count = 0;
		$drop = 0;

		$data = Cache::get('newStatistics', '[]');
		$data = json_decode($data, true);
		Cache::forget('newStatistics');

		if($job->attempts() > 1){
			Log::emergency('Adding statistics failed after '.Carbon::now()->diffInSeconds($start).' seconds.');
			Cache::put('newStatistics', $data, 30);
			$job->delete();

			return;
		}else if(count($data) == 0){
			Log::warning('No data, process stopped.');
			$job->delete();

			return;
		}

		$sInserts = array();
		$pInserts = array();

		$limitedKeys = Config::get('statistics.limited-keys');
		$allowedKeys = Config::get('statistics.tracked');

		Log::notice(count($data).' stats being processed.');

		foreach($data as $dataObject){
			$server = $dataObject['server'];
			$banned_server = DB::table('banned_server')->where('server', $server)->get();
			if(count($banned_server) == 0){
				;
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
						}
					}else if(!in_array($key, $limitedKeys) && in_array($key, $allowedKeys)){
						$count++;
						array_push($pairs, array($key => $value));
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

		$stop = Carbon::now()->diffInSeconds($start);
		Log::notice('Stats have finished processing. This took '.$stop.' seconds. '.$count.' new pieces of data have been entered. '.$drop.' dropped.');
		$job->delete();
	}
}
