<?php
namespace BattleTools\Statistics;

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class Plugins {
	public static function getPluginUsage(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));

		$table = DB::table('plugin_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('plugin', DB::raw('count(distinct server) as total'))->
			groupBy('plugin')->
			remember($diff)->get();

		return $table;
	}

	public static function getVersionStatistics($plugin){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));

		$pluginStatistics = DB::table('plugin_statistics')
			->select(
				DB::raw('count(distinct server) as count'),
				DB::raw('(FLOOR(UNIX_TIMESTAMP(inserted_on)/'.($interval*60).')) as time'),
				'version')
			->where('plugin', $plugin)
			->where('inserted_on', '<', DateUtil::getTimeToThirty())
			->groupBy('version', 'time')
			->orderBy('time')
			->remember($diff)->get();

		$times = array();
		$data = array();
		$versions = array();
		$counts = array();
		foreach($pluginStatistics as $stat){
			$times[] = $stat->time;
			$versions[] = $stat->version;
			$counts[$stat->version][$stat->time] = intval($stat->count);
		}

		$times = array_unique($times);
		$versions = array_unique($versions);

		foreach($versions as $version){ // Check every statistic
			foreach($times as $time){ // Loop through every time
				if(!array_key_exists($time, $counts[$version])){ // If statistic doesn't already have data from the database
					$data[$version][] = array($time, null); // Set the statistic to null
				}else{
					$data[$version][] = array($time, $counts[$version][$time]); // Or else set the statistic to the database value
				}
			}
		}

		$sendData = array();
		foreach(array_keys($data) as $key){
			$thisData = array();
			foreach($data[$key] as $part){
				$thisData[] = array(Carbon::createFromTimestampUTC($part[0]*$interval*60)->getTimestamp()*1000, $part[1]);
			}
			$sendData[] = array('name' => array_search($data[$key], $data), 'data' => $thisData);
		}

		return $sendData;
	}



}
