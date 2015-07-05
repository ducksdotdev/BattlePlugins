<?php


namespace App\Tools\Misc;


use Illuminate\Support\Facades\Cache;

class GitHub {


    protected static $base_url = 'https://api.github.com/';

    public static function getEventsFeed($feed = 'battleplugins', $type = 'org', $limit = 3) {
        return Cache::get('github_feed', function () use ($feed, $type, $limit) {
            $url = str_plural($type) . '/' . $feed . '/events';
            $params = [
                'per_page' => $limit
            ];

            $data = static::getFeed($url, $params);
            Cache::put('github_feed', $data, 30);

            return $data;
        });
    }

    public static function getAvatar($user) {
        return Cache::get('avatar_' . $user, function () use ($user) {
            $url = 'users/' . $user;
            $data = static::getFeed($url)->avatar_url;
            Cache::put('avatar' . $user, $data, 60);
            return $data;
        });
    }

    public static function getIssues() {
        return Cache::get('gitIssues', function () {
            $repos = 'orgs/BattlePlugins/repos';
            $repos = static::getFeed($repos);

            $issues = [];
            foreach($repos as $repo){
                $url = 'repos/' . $repo->full_name . '/issues';
                $issues = array_merge($issues, static::getFeed($url));
            }

            Cache::put('gitIssues', $issues, 60);

            return $issues;
        });
    }

    private static function getFeed($url, $params = []) {
        $url = static::$base_url . $url;

        $params = array_merge([
            'client_id'     => env('GITHUB_APP_ID'),
            'client_secret' => env('GITHUB_APP_SECRET')
        ], $params);

        $url = $url . '?' . http_build_query($params);

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