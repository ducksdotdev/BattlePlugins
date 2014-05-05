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

			$data = array();
			foreach($pluginStatistics as $stat){
				$data[] = array((new Carbon($stat->inserted_on))->getTimestamp() * 1000, $stat->count);
			}

			$file = $path.'/'.$plugin.'.json';

			if(file_exists($file)){
				$data = array_merge(json_decode(file_get_contents($file)), $data);
			}

			file_put_contents($file, json_encode($data));
			Cache::forever($plugin.'Statistics', $data);
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