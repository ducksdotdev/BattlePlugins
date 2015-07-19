<?php

namespace App\Tools\URL;

use App\Tools\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        if (!starts_with($req, ['https://', 'http://']))
            $req = 'http://' . $req;

        if (static::isUrl($req) && static::remoteFileExists($req)) {
            $url = ShortUrl::whereUrl($req)->first();

            if (!$url) {
                $path = SlugGenerator::generate();

                ShortUrl::create([
                    'url'  => $req,
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

    public static function isOnline($host) {
        exec("ping -c 4 " . $host, $outcome, $status);
        return (0 == $status);
    }

    public static function remoteFileExists($url, $cache = false, $cacheLength = 60) {
        if ($cache) {
            Cache::get($url . '_file_exists', function () use ($url, $cacheLength) {
                $status = static::checkFileExists($url);
                Cache::put($url . '_file_exists', $status, $cacheLength);
                return $status;
            });
        } else
            return static::checkFileExists($url);
    }

    private static function checkFileExists($url) {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        $ret = false;

        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($statusCode >= 200 && $statusCode <= 400)
                $ret = true;
        }

        curl_close($curl);

        return $ret;
    }

}