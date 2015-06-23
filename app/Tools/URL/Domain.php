<?php

namespace App\Tools\URL;

use App\Tools\Models\ShortUrl;
use Carbon\Carbon;
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

    public static function shorten($req)
    {
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
                $url->last_used = Carbon::now();
                $url->save();
                return $url->path;
            }
        }
    }

}