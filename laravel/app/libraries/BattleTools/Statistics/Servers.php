<?php
namespace BattleTools\Statistics;

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Servers {

	public static function getTotals(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));
		$path = Config::get('statistics.location')."/totals.json";

		return Cache::get('getTotalServers', function () use ($interval, $diff, $path){
			$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*'.($interval*60).') as time from (select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/'.($interval*60).')) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" group by server, newTime) as st1 group by newTime order by time');

			$stats = json_decode(file_get_contents($path));
			$stats = array_merge($stats, $table);
			file_put_contents($path, $stats);

			Cache::put('getTotalServers', $stats, $diff);

			return $table;
		});
	}

	public static function getAuthenticationModes(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));

		$table = DB::table('server_statistics')->
		where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
		where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
		whereNotNull('bOnlineMode')->
		select('bOnlineMode', DB::raw('count(distinct server) as total'))->
		groupBy('bOnlineMode')->
		remember($diff)->get();

		return $table;
	}

}
