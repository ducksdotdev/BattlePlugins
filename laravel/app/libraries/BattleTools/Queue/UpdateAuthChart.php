<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UpdateAuthChart{

	public function fire($job, $data){
		$diff = DateUtil::getTimeToThirty()->addMinutes(30);
		Cache::put('getAuthModeRunning', true, $diff);

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

		Cache::put('getAuthModeRunning', false, $diff);

		$job->delete();
	}
}