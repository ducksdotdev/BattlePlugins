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

        });

        $this->afterFilter(function() use ($controller){
            Session::flush();
        });

        parent::setActive('Tools');
    }

    public function set(){
        $value = Input::get('value');

        if(!Input::has('key')){
            return Response::json('Key is blank');
        }

        if(Input::has('plugin')){
            $plugin = Input::get('plugin');
            $check = DB::table('plugins')->where('name', $plugin)->get();
            if(count($check) == 0){
                return Response::json('Plugin not found');
            }
        }else{
            $plugin = 'Bukkit';
        }

        $minecraft = new MinecraftStatus(Session::get('serverIp'), Session::get('serverPort'));
        if(!$minecraft->Online){
            return Response::json("Not a Minecraft server");
        }

        $key = Input::get('key');
        $server = Session::get('serverIp');
        $query = DB::table('statistics')->where('key', $key)->where('server', $server);

        if(Input::has('value')){
            if(count($query->get()) > 0){
                $query->update('value', $value);
            }else{
                $query->insert(array(
                    'server' => $server,
                    'plugin' => $plugin,
                    'key' => $key,
                    'value' => $value
                ));
            }
        }else{
            $query->delete();
        }
    }

    public function get(){
        if(!Input::has('key')){
            return Response::json('No key');
        }

        $key = Input::get('key');

        if(Input::has('server')){
            $server = Input::get('server');
        }else{
            $server = Session::get('serverIp');
        }

        $query = DB::table('statistics')->where('server', $server)->where('key', $key)->get();
        return Response::json($query);

    }
}
