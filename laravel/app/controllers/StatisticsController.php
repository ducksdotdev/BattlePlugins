<?php

use BattleTools\Util\DateUtil;
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

		if(Cache::has('newStatistics')){
			$data = Cache::get('newStatistics');
		}else{
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
			$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes(30));

			$interval = Config::get('statistics.interval') * 60;

			$table = DB::select('select count(distinct server) as nServers, sum(avg_players) as nPlayers, FROM_UNIXTIME(newTime*'.$interval.') as time from (select server,round(avg(bPlayersOnline)) as avg_players, inserted_on as timestamp, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/'.$interval.')) as newTime from server_statistics as innerTable where innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" innerTable.inserted_on>"'.Carbon::now()->subWeek().'" group by server, newTime) as st1 group by newTime order by time');

			$json = Response::json($table);

			Cache::put('getTotalServers', $json, $diff);

			return $json;
		});
	}

	public function getPluginCount(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));

		$table = DB::table('plugin_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('plugin', DB::raw('count(distinct server) as total'))->
			groupBy('plugin')->
			remember($diff)->get();

		return Response::json($table);
	}

	public function getAuthMode(){
		$interval = Config::get('statistics.interval');
		$diff = Carbon::now()->diffInMinutes(DateUtil::getTimeToThirty()->addMinutes($interval));

		$table = DB::table('server_statistics')->
			where('inserted_on', '>', DateUtil::getTimeToThirty()->subMinutes($interval))->
			where('inserted_on', '<', DateUtil::getTimeToThirty()->subMinute())->
			select('bOnlineMode', DB::raw('count(distinct server) as total'))->
			groupBy('bOnlineMode')->
			remember($diff)->get();

		return Response::json($table);
	}

	public function getPluginInformation($plugin, $type){
		$interval = Config::get('statistics.interval');
		$plugins = DB::table('plugins')->where('name', $plugin)->first();
		if(count($plugins) > 0){
			switch($type){
				case 'version':
					$pluginStatistics = DB::select('select count(distinct server) as count, version, FROM_UNIXTIME(newTime*'.($interval * 60).') as time from (select server, inserted_on as timestamp, version, (FLOOR(UNIX_TIMESTAMP(innerTable.inserted_on)/'.($interval * 60).')) as newTime, plugin from plugin_statistics as innerTable where innerTable.plugin="'.$plugins->name.'" and innerTable.inserted_on<"'.DateUtil::getTimeToThirty().'" and innerTable.inserted_on>"'.Carbon::now()->subWeek().'" group by server, newTime) as st1 group by newTime order by time');

					$data = array();
					$times = array();
					foreach($pluginStatistics as $stat){
						$times[] = $stat->time;
					}

					$times = array_unique($times);

					$sendData = array();
					foreach($data as $piece){
						$thisData = array();
						$needs = $times;
						foreach($piece as $part){
							$thisData[] = $part;
							unset($needs[$part[0]]);
						}

						foreach($needs as $need){
							$thisData[] = array($need, null);
						}

						$sendData[] = array('name' => array_search($piece, $data), 'data' => $thisData);
					}

					return Response::json($sendData);
				default:
					return Response::make('', 204);
			}
		}else{
			return Response::make('', 204);
		}
	}
}
