<?php

namespace App\Tools\URL;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Domain
{

    public static function getTld(Request $request)
    {
        return substr($request, strrpos($request, ".")+1);
    }

    public static function isUrl($url)
    {
        $validator = Validator::make(['url' => $url], ['url' => 'url']);
        return !$validator->fails();
    }

    public static function stripTrailingSlash($url){
        return rtrim($url, "/");
    }

}