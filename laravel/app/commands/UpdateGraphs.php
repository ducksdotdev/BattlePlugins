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

	private function updateAuthMode(){
		$interval = Config::get('statistics.interval');
		$path = Config::get('statistics.location')."/overall/authmode.json";

		$table = DB::table('server_statistics')->
		where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
		where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
		whereNotNull('bOnlineMode')->
		select('bOnlineMode', DB::raw('count(distinct server) as total'))->
		groupBy('bOnlineMode')->get();

		file_put_contents($path, json_encode($table));
		Cache::forever('getAuthMode', $table);
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

			if(file_exists($file)){
				$oldData = json_decode(file_get_contents($file));
				foreach($oldData as $d){
					foreach($d->data as $part){
						$times[] = intval($part[0])/1000;
					}
				}
			}

			foreach ($pluginStatistics as $stat) {
				$times[] = $stat->time;
				$versions[] = $stat->version;
				$counts[$stat->version][$stat->time] = intval($stat->count);
			}

			$times = array_unique($times);
			rsort($times);

			$versions = array_unique($versions);

			Log::info($times);

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
			foreach (array_keys($data) as $key) {
				$thisData = array();
				foreach ($data[$key] as $part) {
					$thisData[] = array(Carbon::createFromTimestampUTC($part[0] * $interval * 60)->getTimestamp() * 1000, $part[1]);
				}
				$sendData[] = array('name' => array_search($data[$key], $data), 'data' => $thisData);
			}

			if(file_exists($file)){
				$sendData = array_merge($oldData, $sendData);
			}

			file_put_contents($file, json_encode($sendData));
			Cache::forever($plugin.'Statistics', $sendData);
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

		file_put_contents($path, json_encode($table));

		Cache::forever('pluginUsage', $table);
	}
}