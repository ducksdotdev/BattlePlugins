<?php

use BattleTools\UserManagement\UserSettings;

class DeveloperController extends BaseController {

    public function __construct() {
        parent::setActive('Developer');
        $this->beforeFilter('auth.developer');
    }

    public function getStatistics(){
        $vars['title'] = 'Statistics';
        $vars['apiRequests'] = DB::table('api_requests')->
            select('*', DB::raw('count(*) as total'))->
            groupBy('route','ip')->
            orderBy('total', 'desc')->
            get();

        $vars['statisticRequests'] =  DB::table('statistic_requests')->
            select('*', DB::raw('count(*) as total'))->
            groupBy('plugin','server')->
            orderBy('total', 'desc')->
            get();

        $usernames = array();

        foreach($vars['apiRequests'] as $request){
            $usernames[$request->user_id] = UserSettings::getUsernameFromId($request->user_id);
        }

        $vars['usernames'] = $usernames;

        return View::make('developer.statistics', $vars);
    }

    public function clearAPIRequests(){
        DB::table('api_requests')->delete();
        return Redirect::to('/developer/statistics');
    }

    public function clearStatisticRequests(){
        DB::table('statistic_requests')->delete();
        return Redirect::to('/developer/statistics');
    }

}
