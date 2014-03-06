<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UpdateAuthChart{

	public function fire($job, $data){
		$diff = DateUtil::getTimeToThirty()->addMinutes(30);

		$table = DB::table('server_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			where('key', 'bOnlineMode')->
			select('value', DB::raw('count(*) as total'))->
			groupBy('value')->
			get();

		$json = Response::json($table);

		Cache::put('getAuthMode', $json, $diff);
		Cache::forever('getAuthModeMemory', $json);

		$job->delete();
	}
}