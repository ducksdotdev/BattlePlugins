<?php

namespace BattleTools\Util;

class Subdomains{

    public static function extractDomain($domain){
        if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches))
        {
            return $matches['domain'];
        } else {
            return $domain;
        }
    }

    public static function extractSubdomains($domain){
        $subdomains = $domain;
        $domain = extract_domain($subdomains);

        $subdomains = rtrim(strstr($subdomains, $domain, true), '.');

        return $subdomains;
    }

}
