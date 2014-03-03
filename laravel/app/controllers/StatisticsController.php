<?php

use BattleTools\Util\ListSentence;
use BattleTools\Util\MinecraftStatus;
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

		$minecraft = new MinecraftStatus(Session::get('serverIp'), Session::get('serverPort'));
		if(!$minecraft->Online && Config::get('statistics.check-minecraft')){
			return Response::json(array('errors' => "Not a Minecraft server"));
		}

		$server = Session::get('serverIp');

		$cache = Cache::get('statistics');
		$cache[] = array(
			'keys' => $keys,
			'server' => $server
		);

		Cache::forever('statistics', $cache);

		return Response::json('success');
	}

	private function getTime(){
		$time = Carbon::now();
		if($time->minute > 30){
			$time->minute = 30;
		}else{
			$time->minute = 0;
		}
		$time->second = 0;

		return $time;
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
		$table = DB::table('server_statistics')->
			where('key', 'bPlayersOnline')->
			select(DB::raw('inserted_on as timestamp'), DB::raw('count(*) as servers'),
				DB::raw('sum(value) as players'))->
			groupBy('inserted_on')->
			orderBy('timestamp', 'desc')->
			take(336)->get();

		if(self::getTime() == $table[0]->timestamp){
			array_shift($table);
		}

		$table = array_reverse($table);

		return Response::json($table);
	}

	public function getPluginCount(){
		$table = DB::table('plugin_statistics')->
			where('inserted_on', self::getTime()->subMinutes(30))->
			select('plugin', DB::raw('count(*) as total'))->
			groupBy('plugin')->
			get();

		return Response::json($table);
	}
}
