<?php

namespace App\Tools\URL;

use App\Tools\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Domain {

    public static function getTld(Request $request) {
        return substr($request, strrpos($request, ".") + 1);
    }

    public static function isUrl($url) {
        $validator = Validator::make(['url' => $url], ['url' => 'url']);
        return !$validator->fails();
    }

    public static function stripTrailingSlash($url) {
        return rtrim($url, "/");
    }

    public static function shorten($req) {
        $req = static::stripTrailingSlash($req);

        if (static::isUrl($req)) {
            $url = ShortUrl::whereUrl($req)->first();

            if (!$url) {
                $path = SlugGenerator::generate();

                ShortUrl::create([
                    'url' => $req,
                    'path' => $path
                ]);

                return $path;
            } else {
                ShortUrl::whereUrl($req)->update([
                    'last_used' => Carbon::now()
                ]);
                return $url->path;
            }
        }

        return null;
    }

    public static function isOnline($domain) {
        if(!static::isUrl($domain))
            return false;

        //initialize curl
        $curlInit = curl_init($domain);
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        //get answer
        $response = curl_exec($curlInit);

        curl_close($curlInit);

        if ($response) return true;

        return false;
    }

}