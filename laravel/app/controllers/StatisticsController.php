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

            if(count(Input::all()) > 0){
                $inputs = ListSentence::toSentence(Input::all());
            }else{
                $inputs = $request->getRequestUri();
                $inputs = str_replace('/statistics/','',$inputs);
            }

            DB::table('statistic_requests')->insert(array(
                'server' => $ip,
                'requested_on' => Carbon::now(),
                'route' => '/'.$route->getPath(),
                'inputs' => $inputs,
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
        if(!Input::has('key')){
            return Response::json('Key is blank');
        }

        $minecraft = new MinecraftStatus(Session::get('serverIp'), Session::get('serverPort'));
        if(!$minecraft->Online){
            return Response::json("Not a Minecraft server");
        }

        $server = Session::get('serverIp');
        $count = DB::table('statistics')->where('inserted_on', '>', Carbon::now()->subHour())->where
            ('server', $server)->get();

        $key = Input::get('key');
        $limitedKeys = Config::get('statistics.limited-keys');
        if($count > 0 && in_array($key, $limitedKeys)){
            $when = DateUtil::getCarbonDate($count->inserted_on)->addHour()->diffForHumans();
            return Response::json("You must wait ".$when." before making another statistics request.");
        }

        $allowedKeys = Config::get('statistics.tracked');

        if(!in_array($key, $allowedKeys)){
            return Response::json($key.' not recognized');
        }

        $query = DB::table('statistics')->where('key', $key)->where('server', $server);

        if(Input::has('value')){
            $value = Input::get('value');

            $time = Carbon::now();
            $time->minute = 0;
            $time->second = 0;

            $query->insert(array(
                'server' => $server,
                'key' => $key,
                'value' => $value,
                'inserted_on' => $time
            ));

            return Response::json('updated');
        }
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
