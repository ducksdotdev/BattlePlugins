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

            DB::table('statistic_requests')->insert(array(
                'server' => $ip,
                'requested_on' => Carbon::now(),
                'route' => '/'.$route->getPath(),
                'inputs' => ListSentence::toSentence(Input::all()),
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

            $query->insert(array(
                'server' => $server,
                'key' => $key,
                'value' => $value,
                'inserted_on' => Carbon::now()
            ));

            return Response::json('updated');
        }else{
            $query->delete();
            return Response::json('deleted');
        }
    }

    public function get($key, $server=null){
        if($server == null){
            $query = DB::table('statistics')->where('key', $key)->get();
        }else{
            $query = DB::table('statistics')->where('server', $server)->where('key', $key)->get();
        }
        return Response::json($query);
    }
}
