<?php

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class StatisticsController extends BaseController{

	public function __construct(){
		$controller = $this;

		$this->beforeFilter(function ($route, $request) use ($controller){
			$ip = $request->getClientIp();
			$port = $request->getPort();

			Session::put("serverIp", $ip);
			Session::put("serverPort", $port);

			parent::setActive('Tools');
		}, array('except' => array('displayStatistics', 'getTotalServers')));

		$this->afterFilter(function () use ($controller){
			Session::flush();
		});
	}

	public function displayStatistics(){
		parent::setActive('Resources');

		$vars['title'] = 'Statistics';
		$vars['curTime'] = Carbon::now();

		return View::make('statistics', $vars);
	}

	public function set(){
		$keys = Input::all();

		$server = Session::get('serverIp');

		$data = Cache::get('newStatistics', array());
		if(!is_array($data)){
			$data = array();
		}

		$data[] = array(
			'keys'   => $keys,
			'server' => $server,
			'port'   => Session::get('serverPort'),
			'time'   => Carbon::now()->toDateTimeString()
		);

		Cache::put('newStatistics', $data, 30);

		return Response::make('', 204);
	}

	public function getTotalServers(){
		return Cache::get('getTotalServers', function (){
			Queue::push('BattleTools\Queue\UpdateServerGraph');
			return Cache::get('getTotalServersHold');
		});
	}

	public function getPluginCount(){
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes(30));

		$table = DB::table('plugin_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('plugin', DB::raw('count(distinct server) as total'))->
			groupBy('plugin')->
			remember($diff)->get();

		return Response::json($table);
	}

	public function getAuthMode(){
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes(30));

		$table = DB::table('server_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('bOnlineMode', DB::raw('count(distinct server) as total'))->
			groupBy('bOnlineMode')->
			remember($diff)->get();

		return Response::json($table);
	}

	public function getPluginInformation($plugin){
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes(30));

		$table = DB::table('plugin_statistics')->
			where('inserted_on', '<', DateUtil::getTimeToThirty())->
			where('plugin', $plugin)->
			select('version', 'inserted_on as timestamp', DB::raw('count(*) as total'))->
			groupBy('version', DB::raw('2 * HOUR( inserted_on ) + FLOOR( MINUTE( inserted_on ) / 30 )'))->
			orderBy('timestamp', 'desc')->
			take(336)->remember($diff)->get();

		if(count($table) > 0){
			if(DateUtil::getTimeToThirty() == $table[0]->timestamp){
				array_shift($table);
			}

			array_reverse($table);

			return Response::json($table);
		}
	}
}
