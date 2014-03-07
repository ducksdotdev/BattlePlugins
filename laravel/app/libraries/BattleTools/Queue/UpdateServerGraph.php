<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UpdateServerGraph{

	public function fire($job, $data){
		$start = round(microtime(true) * 1000);

		if($job->attempts() > 1){
			Log::emergency('Updating server graph failed after '.round(microtime(true) * 1000) - $start.'ms.');
			Cache::put('newStatistics', $data, 30);
			$job->delete();

			return;
		}

		$diff = DateUtil::getTimeToThirty()->addMinutes(30);

		$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*1800) as time from (select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/1800)) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" group by server, newTime) as st1 group by newTime order by time desc limit 336');

		if(count($table) > 0){
			if(DateUtil::getTimeToThirty() <= $table[0]->time){
				array_shift($table);
			}
		}

		$table = array_reverse($table);

		$json = Response::json($table);

		Cache::put('getTotalServers', $json, $diff);
		Cache::forever('getTotalServersHold', $json);
		Log::notice('Server statistics graph has been updated. This took '.round(microtime(true) * 1000) - $start.'ms.');

		$job->delete();
	}
}
