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

		$data = json_decode(Cache::get('newStatistics', json_encode(array())), true);
		if(!is_array($data)){
			$data = array();
		}

		array_push($data, array(
			'keys'   => $keys,
			'server' => $server,
			'port'   => Session::get('serverPort'),
			'time'   => Carbon::now()->toDateTimeString()
		));

		Cache::put('newStatistics', json_encode($data), 30);
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

	public function getTotalServers(){
		return Cache::get('getTotalServers', function (){
			$diff = DateUtil::getTimeToThirty()->addMinutes(30);

			$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*1800) as time from (      select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/1800)) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" group by server, newTime) as st1 group by newTime order by time desc limit 336');

			if(count($table) > 0){
				if(DateUtil::getTimeToThirty() <= $table[0]->time){
					array_shift($table);
				}

				$table = array_reverse($table);

				$json = Response::json($table);

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
				select('plugin', DB::raw('count(distinct server) as total'))->
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
				select('bOnlineMode', DB::raw('count(distinct server) as total'))->
				groupBy('bOnlineMode')->
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
