<?php

use BattleTools\Util\ListSentence;
use BattleTools\Util\MinecraftStatus;
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

        $key = Input::get('key');
        $server = Session::get('serverIp');
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
        $players =  DB::table('statistics')->
            where('key', 'players')->
            select(DB::raw('sum(value) as players'))->
            groupBy('inserted_on')->
            get();

        $temp = array();
        foreach($players as $player){
            $temp[] = $player->players;
        }

        $players = $temp;

        $players = array(
            'name' => 'Players',
            'data' => $players
        );

        $servers =  DB::table('statistics')->
            where('key', 'players')->
            select(DB::raw('count(*) as servers'))->
            groupBy('inserted_on')->
            get();

        $temp = array();
        foreach($servers as $server){
            $temp[] = $server->servers;
        }

        $servers = $temp;

        $servers = array(
            'name' => 'servers',
            'data' => $servers
        );

        $table = $servers+$players;

        return Response::json($table);
    }
}
