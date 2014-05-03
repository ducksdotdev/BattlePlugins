<?php
namespace BattleTools\Statistics;

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Servers {



	public static function getTotals(){
		return Cache::get('getTotalServers');
	}

	public static function getAuthenticationModes(){
		return Cache::get('getAuthMode');
	}

}
