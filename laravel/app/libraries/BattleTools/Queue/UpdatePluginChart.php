<?php
namespace BattleTools\Queue;

use BattleTools\Util\DateUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UpdatePluginChart{

	public function fire($job, $data){
		$diff = DateUtil::getTimeToThirty()->addMinutes(30);
		Cache::put('getPluginCountRunning', true, $diff);

		$table = DB::table('plugin_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('plugin', DB::raw('count(*) as total'))->
			groupBy('plugin')->
			get();

		$json = Response::json($table);

		Cache::put('getPluginCount', $json, $diff);
		Cache::forever('getPluginCountMemory', $json);

		Cache::put('getPluginCountRunning', false, $diff);

		$job->delete();
	}
}