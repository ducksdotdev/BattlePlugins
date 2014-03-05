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

		$data = array(
			'keys'   => $keys,
			'server' => $server,
			'port'   => Session::get('serverPort'),
		);

		Queue::push('BattleTools\Queue\UpdateStatistics', $data);

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
			$running = Cache::get('totalServersRunning');
			if(!$running){
				Queue::push('BattleTools\Queue\UpdateServerChart');
			}

			return Cache::get('getTotalServersMemory');
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

			$json = Response::json($table);
			Cache::put('getPluginCount', $json, $diff);

			return $json;
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
				get();

			$json = Response::json($table);

			$diff = DateUtil::getTimeToThirty()->addMinutes(30);
			Cache::put('get'.$plugin.'Information', $table, $diff);

			return $json;
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
