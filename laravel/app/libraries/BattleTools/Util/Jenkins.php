<?php

namespace BattleTools\Util;

class Jenkins {

    public static function getLatestBuild($url, $job){
        $contents = @file_get_contents($url . "/job/" . $job . "/lastSuccessfulBuild/");
        $matches = array();
        $match = preg_match('/\<title\>[A-Za-z0-9-_]+ \#([0-9]+) \[Jenkins\]\<\/title\>/i', $contents, $matches);
        if ($match == 0){
            $array = array(
                'exists' => false,
                'build' => 'None',
                'url' => '#'
            );
        }else{
            $buildnum = $matches[1];
            $array = array(
                'exists' => true,
                'build' => $buildnum,
                'url' => $url.'/job/'.$job.'/'.$buildnum
            );
        }
        return $array;
    }

}
