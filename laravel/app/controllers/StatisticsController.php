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

        $minecraft = new MinecraftStatus(Session::get('serverIp'), Session::get('serverPort'));
        if(!$minecraft->Online && Config::get('statistics.check-minecraft')){
            return Response::json("Not a Minecraft server");
        }

        $server = Session::get('serverIp');

        $time = Carbon::now();
        if($time->minute > 30){
            $time->minute = 30;
        }else{
            $time->minute = 0;
        }
        $time->second = 0;

        $success = array();
        $error = array();

        foreach(array_keys($keys) as $key){
            if(ListSentence::startsWith($key, 'p')){
                $plugin = substr($key, 1);

                $plugins = DB::table('plugins')->select('name')->get();

                $count = DB::table('plugin_statistics')
                    ->where('inserted_on', $time)
                    ->where('server', $server)
                    ->where('plugin', $plugin)
                    ->get();

                if(count($count) == 0 && in_array($plugin, $plugins)){
                    $value = $keys[$key];

                    $success[$key] = $value;

                    DB::table('plugin_statistics')->insert(array(
                        'server' => $server,
                        'plugin' => $plugin,
                        'version' => $value,
                        'inserted_on' => $time
                    ));
                }
            }else{

                $count = DB::table('server_statistics')
                    ->where('inserted_on', $time)
                    ->where('server', $server)
                    ->where('key', $key)
                    ->select('key')
                    ->get();

                if(count($count) == 0){
                    if(!(in_array($key, $count) && in_array($key, Config::get('statistics.limited-keys')))){
                        $allowedKeys = Config::get('statistics.tracked');

                        if(in_array($key, $allowedKeys)){
                            $value = $keys[$key];

                            $success[$key] = $value;

                            DB::table('server_statistics')->insert(array(
                                'server' => $server,
                                'key' => $key,
                                'value' => $value,
                                'inserted_on' => $time
                            ));
                        }else{
                            $error[$key] = 'invalid';
                        }
                    }else{
                        $error[$key] = 'duplicate';
                    }
                }else{
                    $error[$key] = 'exists';
                }
            }
        }

        return Response::json(array('updated', $success, $error));
    }

    public function get($column, $key, $server=null){
        if(!in_array($column, array('server','key','value','inserted_on'))){
            $column = '*';
        }

        if($server == null){
            $query = DB::table('server_statistics')->where('key', $key)->
                select($column)->get();
        }else{
            $query = DB::table('server_statistics')->where('server', $server)->where('key', $key)->
                select($column)->get();
        }
        return Response::json($query);
    }

    public function getTotalServers(){
        $table =  DB::table('server_statistics')->
            where('key', 'bPlayersOnline')->
            select(DB::raw('inserted_on as timestamp'), DB::raw('count(*) as servers'),
                DB::raw('sum(value) as players'))->
            groupBy('inserted_on')->
            get();

        return Response::json($table);
    }
}
