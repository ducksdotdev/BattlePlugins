<?php


namespace App\Tools\Misc;


use Illuminate\Support\Facades\Cache;

class GitHub {

    public static function getFeed($feed = 'battleplugins', $type = 'org') {
        return Cache::put('github_feed', static::sendFeedRequest($feed, 'events', $type), 30);
    }

    private static function sendFeedRequest($feed, $method, $type) {
        $url = 'https://api.github.com/' . str_plural($type) . '/' . $feed . '/' . $method;
        $params = [
            'client_id'     => env('GITHUB_APP_ID'),
            'client_secret' => env('GITHUB_APP_SECRET')
        ];
        $url = $url . '?' . http_build_query($params);

        dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'apache');
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    public static function convertEvent($event) {
        return config('github.events.' . $event);
    }

}