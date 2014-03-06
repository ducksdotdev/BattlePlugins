<?php

use BattleTools\Util\DateUtil;
use BattleTools\Util\ListSentence;
use Carbon\Carbon;

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
		$data = json_decode($data, true);

		array_push($data, array(
			'keys'   => $keys,
			'server' => $server,
			'port'   => Session::get('serverPort'),
			'time'   => Carbon::now()->toDateTimeString()
		));

		$data = json_encode($data);

		Cache::put('newStatistics', $data, 30);
		if(count($data) >= Config::get('statistics.max-cached')){
			$lastUpdate = Cache::get('lastStatisticsUpdate', function (){
				$now = Carbon::now();
				Cache::put('lastStatisticsUpdate', $now, 1);

				return $now->subSeconds(30);
			});

			if(Carbon::now()->diffInSeconds($lastUpdate) > 30){
				Artisan::call('battle:forcesave');
			}
		}

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
			$diff = DateUtil::getTimeToThirty()->addMinutes(30);

			$players = DB::select('select avg(value) as avg_players, inserted_on as timestamp from server_statistics as innerTable where innerTable.inserted_on < "'.DateUtil::getTimeToThirty().'" and innerTable.key = "bPlayersOnline" group by  (2 * HOUR( innerTable.inserted_on ) + FLOOR( MINUTE( innerTable.inserted_on ) / 30 ))');

			$servers =  DB::table('server_statistics')->
				where('key', '')->
				where('inserted_on', '<', DateUtil::getTimeToThirty())->
				select(DB::raw('inserted_on as timestamp'), DB::raw('count(distinct server) as servers'))->
				groupBy(DB::raw(''))->
				orderBy('timestamp', 'desc')->
				take(336)->get();

			if(count($players) > 0 && count($servers) > 0){
				if(DateUtil::getTimeToThirty() <= $players[0]->timestamp){
					array_shift($players);
				}
				if(DateUtil::getTimeToThirty() <= $servers[0]->timestamp){
					array_shift($servers);
				}

				$players = array_reverse($players);
				$servers = array_reverse($servers);

				$json = Response::json(array('players'=>$players,'servers'=>$servers));

				Cache::put('getTotalServers', $json, $diff);

				return $json;
			}
		});
	}

	public function getPluginCount(){
		return Cache::get('getPluginCount', function (){
			$diff = DateUtil::getTimeToThirty()->addMinutes(30);

			$table = DB::table('plugin_statistics')->
				where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes(30))->
				where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
				select('plugin', DB::raw('count(*) as total'))->
				groupBy('plugin')->
				get();

			$json = Response::json($table);

			Cache::put('getPluginCount', $json, $diff);

			return $json;
		});
	}

	public function getAuthMode(){
		return Cache::get('getAuthMode', function (){
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

			return $json;
		});
	}

	public function getPluginInformation($plugin){
		return Cache::get('get'.$plugin.'Information', function () use ($plugin){
			$table = DB::table('plugin_statistics')->
				where('inserted_on', '<', DateUtil::getTimeToThirty())->
				where('plugin', $plugin)->
				select('version', 'inserted_on as timestamp', DB::raw('count(*) as total'))->
				groupBy('version', DB::raw('2 * HOUR( inserted_on ) + FLOOR( MINUTE( inserted_on ) / 30 )'))->
				orderBy('timestamp', 'desc')->
				take(336)->get();

			if(count($table) > 0){
				if(DateUtil::getTimeToThirty() == $table[0]->timestamp){
					array_shift($table);
				}

				array_reverse($table);

				$json = Response::json($table);

				$diff = DateUtil::getTimeToThirty()->addMinutes(30);
				Cache::put('get'.$plugin.'Information', $table, $diff);

				return $json;
			}
		});
	}

	public function reload($method){
		$charts = Config::get('statistics.charts');
		if(in_array($method, $charts) || (ListSentence::startsWith($method, "get") && ListSentence::endsWith($method, "Information"))){
			Cache::forget($method);
		}

		return Redirect::to('/statistics');
	}
}
