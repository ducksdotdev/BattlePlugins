<?php

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UpdateGraphs extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'graphs:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update graphs.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		self::updateTotals();
		self::updateAuthMode();
		DB::table('server_statistics')->where('inserted_on', '<', DateUtil::getTimeToThirty())->delete();
		self::updatePlugins();
		self::updatePluginUsage();
		DB::table('plugin_statistics')->where('inserted_on', '<', DateUtil::getTimeToThirty())->delete();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments(){
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions(){
		return array();
	}

	private function updateTotals(){
		$interval = Config::get('statistics.interval');
		$path = Config::get('statistics.location')."/overall/totals.json";

		$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*'.($interval*60).') as time from (select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/'.($interval*60).')) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" group by server, newTime) as st1 group by newTime order by time');

		if(file_exists($path)) {
			$table = array_merge(json_decode(file_get_contents($path)), $table);
		}

		file_put_contents($path, json_encode($table));
		Cache::forever('getTotalServers', $table);
	}

	private function updateAuthMode() {
		$interval = Config::get('statistics.interval');
		$path = Config::get('statistics.location') . "/overall/authmode.json";

		$table = DB::table('server_statistics')->
		where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
		where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
		whereNotNull('bOnlineMode')->
		select('bOnlineMode', DB::raw('count(distinct server) as total'))->
		groupBy('bOnlineMode')->get();

		if (count($table) > 0){
			file_put_contents($path, json_encode($table));
			Cache::forever('getAuthMode', $table);
		}
	}

	private function updatePlugins() {
		$plugins = DB::table('plugins')->get();
		$path = Config::get('statistics.location')."/plugins";
		$interval = Config::get('statistics.interval');

		foreach ($plugins as $plugin) {
			$plugin = $plugin->name;

			$pluginStatistics = DB::table('plugin_statistics')->
			select(
				DB::raw('count(distinct server) as count'),
				DB::raw('(FLOOR(UNIX_TIMESTAMP(inserted_on)/' . ($interval * 60) . ')) as time'),
				'version')->
			where('plugin', $plugin)->
			where('inserted_on', '<', DateUtil::getTimeToThirty())->
			groupBy('version', 'time')->
			orderBy('time')->get();

			$times = array();
			$data = array();
			$versions = array();
			$counts = array();

			$file = $path.'/'.$plugin.'.json';
			$fileExists = file_exists($file);

			if($fileExists){ // If the JSON file exists, we need to add that data in the right spot
				$oldData = json_decode(file_get_contents($file)); // Turn the data into a proper array
				foreach($oldData as $d){ // Loop through the data
					foreach($d->data as $part){ // Loop through each data point for the time series
						$times[] = intval($part[0]); // Add the time to the times array to loop through later
						$versions[] = $d->name; // Add the version in case it no longer exists
						$counts[$d->name][$part[0]] = intval($part[1]); // Add the count for said version at said data point in the time series
					}
				}
			}

			foreach ($pluginStatistics as $stat) { // Loop through the new data
				$time = Carbon::createFromTimestampUTC($stat->time * $interval * 60)->getTimestamp() * 1000; // Convert the timestamp to the HighCharts accepted time
				$times[] = $time; // Add the time to the time array
				$versions[] = $stat->version; // Add the version to the version array
				$counts[$stat->version][$time] = intval($stat->count); // Add the count to the count array
			}

			$times = array_unique($times); // Get unique times
			rsort($times); // Sort the times by value and assign new IDs

			$versions = array_unique($versions); // Get the unique version

			foreach ($versions as $version) { // Check every statistic
				foreach ($times as $time) { // Loop through every time
					if (!array_key_exists($time, $counts[$version])) { // If statistic doesn't already have data from the database
						$data[$version][] = array($time, null); // Set the statistic to null
					} else {
						$data[$version][] = array($time, $counts[$version][$time]); // Or else set the statistic to the database value
					}
				}
			}

			$sendData = array();
			foreach (array_keys($data) as $key) { // Loop through all the data's keys
				$thisData = array();
				foreach ($data[$key] as $part) { // Loop through all the values
					$thisData[] = array($part[0], $part[1]); // Add the time to temp data
				}
				$sendData[] = array('name' => array_search($data[$key], $data), 'data' => $thisData); // Add the data to the final array
			}

			file_put_contents($file, json_encode($sendData)); // Put the data into the file
			Cache::forever($plugin.'Statistics', $sendData); // Cache the data to be displayed by Highcharts
		}
	}

	private function updatePluginUsage(){
		$path = Config::get('statistics.location')."/overall/pluginusage.json";

		$interval = Config::get('statistics.interval');

		$table = DB::table('plugin_statistics')->
		where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
		where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
		select('plugin', DB::raw('count(distinct server) as total'))->
		groupBy('plugin')->get();

		if(count($table) > 0) {
			file_put_contents($path, json_encode($table));
			Cache::forever('pluginUsage', $table);
		}
	}
}