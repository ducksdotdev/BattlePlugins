<?php

use BattleTools\Util\DateUtil;
use Carbon\Carbon;

class StatisticsController extends BaseController{

	public function __construct(){
		$controller = $this;

		$this->beforeFilter(function ($route, $request) use ($controller){
			$ip = $request->getClientIp();
			$port = $request->getPort();

			$banned_server = DB::table('banned_server')->where('server', $ip)->get();
			if(count($banned_server) > 0){
				return Response::json(array('errors' => "Your IP ($ip) is blocked from making requests"));
			}

			DB::table('statistic_requests')->insert(array(
				'server'       => $ip,
				'requested_on' => Carbon::now(),
				'route'        => '/'.$route->getPath(),
			));

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

		return View::make('statistics', $vars);
	}

	public function set(){
		$keys = Input::all();

		$server = Session::get('serverIp');

		$cache = Cache::get('statistics', array());
		$cache[] = array(
			'keys'   => $keys,
			'server' => $server,
			'port'   => Session::get('serverPort'),
			'time'   => Carbon::now()
		);

		Cache::forever('statistics', $cache);

		return Response::json('success');
	}

	public function get($column, $key, $server = null){
		if(!in_array($column, array('server', 'key', 'value', 'inserted_on'))){
			$column = '*';
		}

		if($server == null){
			$query = DB::table('server_statistics')->where('key', $key)->
				select($column)->get();
		}else{
			$query = DB::table('server_statistics')->where('server', $server)->where('key', $key)->
				select($column)->get();
		}

		return Response::json($query);
	}

	public function getTotalServers(){
		return Cache::get('getTotalServers', function (){
			$table = DB::table('server_statistics')->
				where('key', 'bPlayersOnline')->
				select(DB::raw('inserted_on as timestamp'), DB::raw('count(*) as servers'),
					DB::raw('sum(value) as players'))->
				groupBy(DB::raw('2 * HOUR( inserted_on ) + FLOOR( MINUTE( inserted_on ) / 30 )'))->
				orderBy('timestamp', 'desc')->
				take(336)->get();

			if(DateUtil::getTimeToThirty() == $table[0]->timestamp){
				array_shift($table);
			}

			$table = array_reverse($table);

			$diff = DateUtil::getTimeToThirty()->addMinutes(30);
			Cache::put('getTotalServers', $table, $diff);

			return Response::json($table);
		});
	}

	public function getPluginCount(){
		return Cache::get('getPluginCount', function (){
			$table = DB::table('plugin_statistics')->
				where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
				where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
				select('plugin', DB::raw('count(*) as total'))->
				groupBy('plugin')->
				get();

			$diff = DateUtil::getTimeToThirty()->addMinutes(30);
			Cache::put('getPluginCount', $table, $diff);

			return Response::json($table);
		});
	}

	public function getAuthMode(){
		return Cache::get('getAuthMode', function (){
			$table = DB::table('server_statistics')->
				where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
				where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
				where('key', 'bOnlineMode')->
				select('value', DB::raw('count(*) as total'))->
				groupBy('value')->
				get();

			$diff = DateUtil::getTimeToThirty()->addMinutes(30);
			Cache::put('getAuthMode', $table, $diff);

			return Response::json($table);
		});
	}
}
