<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UpdateServerChart{

	public function fire($job, $data){
		$table = DB::table('server_statistics')->
			where('key', 'bPlayersOnline')->
			where('inserted_on', '<', DateUtil::getTimeToThirty())->
			select(DB::raw('inserted_on as timestamp'), DB::raw('count(*) as servers'),
				DB::raw('sum(value) as players'))->
			groupBy(DB::raw('2 * HOUR( inserted_on ) + FLOOR( MINUTE( inserted_on ) / 30 )'))->
			orderBy('timestamp', 'desc')->
			take(336)->get();

		if(count($table) > 0){
			if(DateUtil::getTimeToThirty() == $table[0]->timestamp){
				array_shift($table);
			}

			$table = array_reverse($table);

			$diff = DateUtil::getTimeToThirty()->addMinutes(30);

			$json = Response::json($table);

			Cache::put('getTotalServers', $json, $diff);
			Cache::forever('getTotalServersMemory', $json);

			return $json;
		}
		$job->delete();
	}
}