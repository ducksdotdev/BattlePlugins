<?php

namespace App\Tools\URL;

use App\Models\ShortUrl;
use App\Tools\Repositories\ShortUrlRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * Class Domain
 * @package App\Tools\URL
 */
class Domain {

    /**
     * @param Request $request
     * @return string
     */
    public static function getTld(Request $request) {
        return substr($request, strrpos($request, ".") + 1);
    }

    /**
     * @param $url
     * @return bool
     */
    public static function isUrl($url) {
        $validator = Validator::make(['url' => $url], ['url' => 'url']);
        return !$validator->fails();
    }

    /**
     * @param $url
     * @return string
     */
    public static function stripTrailingSlash($url) {
        return rtrim($url, "/");
    }

    /**
     * @param $req
     * @return null|string
     */
    public static function shorten($req) {
        $req = static::stripTrailingSlash($req);
        if (!starts_with($req, ['https://', 'http://']))
            $req = 'http://' . $req;

        if (static::isUrl($req) && static::remoteFileExists($req)) {
            $url = ShortUrl::whereUrl($req)->first();

            if (!$url) {
                $slug = SlugGenerator::generate();

                ShortUrlRepository::create([
                    'url'       => $req,
                    'slug'      => $slug,
                    'last_used' => Carbon::now()
                ]);

                return $slug;
            } else {
                ShortUrl::whereUrl($req)->update([
                    'last_used' => Carbon::now()
                ]);

                return $url->path;
            }
        }

        return null;
    }

    /**
     * @param $host
     * @return bool
     */
    public static function isOnline($host) {
        exec("ping -c 4 " . $host, $outcome, $status);
        return (0 == $status);
    }

    /**
     * @param $url
     * @param bool|false $cache
     * @param int $cacheLength
     * @return bool
     */
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

    /**
     * @param $url
     * @return bool
     */
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