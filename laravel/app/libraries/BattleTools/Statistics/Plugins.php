<?php
namespace BattleTools\Statistics;

use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Plugins {
	public static function getPluginUsage(){
		return Cache::get('pluginUsage');
	}

	public static function getVersionStatistics($plugin){
		return Cache::get($plugin.'Statistics');
	}
}
