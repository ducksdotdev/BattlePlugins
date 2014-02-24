<?php

use BattleTools\Util\ListSentence;
use BattleTools\Util\MinecraftStatus;
use BattleTools\Util\DateUtil;
use Carbon\Carbon;

class StatisticsController extends BaseController {

    public function __construct() {
        $controller = $this;

        $this->beforeFilter(function ($route, $request) use ($controller) {
            $ip = $request->getClientIp();
            $port =  $request->getPort();

            $banned_server = DB::table('banned_server')->where('server',$ip)->get();
            if(count($banned_server) > 0){
                return Response::json("Your IP ($ip) is blocked from making requests");
            }

            DB::table('statistic_requests')->insert(array(
                'server' => $ip,
                'requested_on' => Carbon::now(),
                'route' => '/'.$route->getPath(),
            ));

            Session::put("serverIp", $ip);
            Session::put("serverPort", $port);

            parent::setActive('Tools');
        }, array('except'=>array('displayStatistics')));

        $this->afterFilter(function() use ($controller){
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

        Log::info(ListSentence::toSentence(array_keys($keys)).'\n'.ListSentence::toSentence(Input::all()));

        $minecraft = new MinecraftStatus(Session::get('serverIp'), Session::get('serverPort'));
        if(!$minecraft->Online && Config::get('statistics.check-minecraft')){
            return Response::json("Not a Minecraft server");
        }

        $server = Session::get('serverIp');

        $time = Carbon::now();
        $time->minute = 0;
        $time->second = 0;

        $count = DB::table('statistics')->where('inserted_on', '>', $time)->where
            ('server', $server)->get();

        $success = array();

        foreach(array_keys($keys) as $key){
            $limitedKeys = Config::get('statistics.limited-keys');
            if(!($count > 0 && in_array($key, $limitedKeys))){

                $allowedKeys = Config::get('statistics.tracked');

                if(in_array($key, $allowedKeys)){

                    $query = DB::table('statistics')->where('key', $key)->where('server', $server);

                    $value = $keys[$key];

                    $success[$key] = $value;

                    $query->insert(array(
                        'server' => $server,
                        'key' => $key,
                        'value' => $value,
                        'inserted_on' => $time
                    ));
                }
            }
        }

        return Response::json(array('updated', $success));
    }

    public function get($column, $key, $server=null){
        if(!in_array($column, array('server','key','value','inserted_on'))){
            $column = '*';
        }

        if($server == null){
            $query = DB::table('statistics')->where('key', $key)->
                select($column)->get();
        }else{
            $query = DB::table('statistics')->where('server', $server)->where('key', $key)->
                select($column)->get();
        }
        return Response::json($query);
    }

    public function getTotalServers(){
        $table =  DB::table('statistics')->
            where('key', 'bPlayersOnline')->
            select(DB::raw('inserted_on as timestamp'), DB::raw('count(*) as servers'),
                DB::raw('sum(value) as players'))->
            groupBy('inserted_on')->
            get();

        return Response::json($table);
    }
}
