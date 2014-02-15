<?php


namespace BattleTools\Util;


use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class DateUtil {

    public static function getDateHtml($date) {
        $carbon = new Carbon($date);
        $fullDate = date('Y-m-d H:i:s', strtotime($date));
        return "<span title='" . $fullDate . " ". Config::get('app.timezone') ."'>" . $carbon->diffForHumans() . "</span>";
    }

    public static function getReadableDate($date) {
        $carbon = new Carbon($date);
        return $carbon->diffForHumans();
    }

    public static function getCarbonDate($date){
        return new Carbon($date);
    }

}
