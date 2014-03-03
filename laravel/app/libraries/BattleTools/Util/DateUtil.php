<?php

namespace BattleTools\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class DateUtil{

	public static function getDateHtml($date){
		$carbon = new Carbon($date);
		$fullDate = date('Y-m-d H:i:s', strtotime($date));

		return "<span title='".$fullDate." ".Config::get('app.timezone')."'>".$carbon->diffForHumans()."</span>";
	}

	public static function getReadableDate($date){
		$carbon = new Carbon($date);

		return $carbon->diffForHumans();
	}

	public static function getCarbonDate($date){
		return new Carbon($date);
	}

	public static function getTimeToNextThirty($minutes=true){
		$nextTime = self::getTimeToThirty()->addMinutes(30);
		if($minutes){
			$diff = Carbon::now()->diffInMinutes($nextTime);
			return $diff < 0 ? $diff * 1 : $diff;
		}else{
			return $nextTime->diffForHumans();
		}
	}

	public static function getTimeToThirty(){
		$time = Carbon::now();
		if($time->minute > 30){
			$time->minute = 30;
		}else{
			$time->minute = 0;
		}
		$time->second = 0;

		return $time;
	}
}
