<?php


namespace App\Tools\Misc;


use Illuminate\Support\Facades\Cache;

class GitHub {

    public static function getEventsFeed($feed = 'battleplugins', $type = 'org', $limit = 3) {
        return Cache::get('github_feed', function () use ($feed, $type, $limit) {
            $url = 'https://api.github.com/' . str_plural($type) . '/' . $feed . '/events';
            $params = [
                'client_id'     => env('GITHUB_APP_ID'),
                'client_secret' => env('GITHUB_APP_SECRET'),
                'per_page'      => $limit
            ];
            $url = $url . '?' . http_build_query($params);

            $data = json_decode(static::getFeed($url));
            Cache::put('github_feed', $data, 30);

            return $data;
        });
    }

    private static function getFeed($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'apache');
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public
    static function convertEvent($event) {
        return config('github.events.' . $event);
    }

}