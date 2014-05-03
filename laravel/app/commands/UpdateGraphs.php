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
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));
		$path = Config::get('statistics.location')."/overall/totals.json";

		$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*'.($interval*60).') as time from (select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/'.($interval*60).')) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" group by server, newTime) as st1 group by newTime order by time');

		$stats = json_decode(file_get_contents($path));
		$stats = is_array($stats) ? $stats = array_merge($stats, $table) : $table;

		file_put_contents($path, json_encode($stats));
		Cache::put('getTotalServers', $stats, $diff);
	}

	private function updateAuthMode(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));
		$path = Config::get('statistics.location')."/overall/authmode.json";

		$table = DB::table('server_statistics')->
		where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
		where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
		whereNotNull('bOnlineMode')->
		select('bOnlineMode', DB::raw('count(distinct server) as total'))->
		groupBy('bOnlineMode')->
		remember($diff)->get();

		file_put_contents($path, json_encode($table));
	}

}