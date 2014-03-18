<?php

use BattleTools\Statistics\Plugins;
use BattleTools\Statistics\Servers;
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

	public function getServerInformation($type){
		switch($type){
			case 'totals':
				return Servers::getTotals();
				break;
			case 'auth':
				Servers::getAuthenticationModes();
				break;
			default:
				return Response::make('', 204);
		}
	}

	public function getPluginInformation($plugin, $type){
		switch($type){
			case 'totals':
				return Plugins::getPluginUsage();
				break;
			case 'version':
				return Plugins::getVersionStatistics($plugin);
				break;
			default:
				return Response::make('', 204);
		}
	}
}
