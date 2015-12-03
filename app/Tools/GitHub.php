<?php


namespace App\Tools;

use Illuminate\Support\Facades\Cache;

/**
 * Class GitHub
 * @package App\Tools\Misc
 */
class GitHub {

    /**
     * @var string
     */
    protected static $base_url = 'https://api.github.com/';

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getEventsFeed($limit = 3) {
        $url = 'orgs/BattlePlugins/events';
        $limit = $limit > 100 ? 100 : $limit;

        $params = [
            'per_page' => $limit
        ];

        $data = static::getFeed($url, $params);
        return $data;
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    private static function getFeed($url, $params = [], $cache = true) {
        $name = str_replace('/', '_', $url);

        foreach ($params as $key => $value)
            $name .= '_' . $key . '_' . $value;

        if ($cache) {
            $data = Cache::get($name, function () use ($url, $params, $name) {
                $data = static::getFeedData($url, $params);
                Cache::put($name, $data, 30);
                return $data;
            });
        } else
            $data = static::getFeedData($url, $params, $name);

        return json_decode($data);
    }

    /**
     * @param $url
     * @param $params
     * @return mixed
     */
    private static function getFeedData($url, $params) {
        $url = static::$base_url . $url;

        $params = array_merge([
            'client_id' => env('GITHUB_APP_ID'),
            'client_secret' => env('GITHUB_APP_SECRET')
        ], $params);

        $url = $url . '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'apache');
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @return array
     */
    public static function getIssues() {
        $repos = 'orgs/BattlePlugins/repos';
        $repos = static::getFeed($repos);

        $issues = [];
        foreach ($repos ?: [] as $repo) {
            $url = 'repos/' . $repo->full_name . '/issues';
            $issues = array_merge($issues, static::getFeed($url));
        }

        return $issues;
    }

    /**
     * @param string $org
     * @return mixed
     */
    public static function getOrgMembers($org = 'battleplugins') {
        $url = 'orgs/' . $org . '/members';
        $data = static::getFeed($url);
        return $data;
    }

    /**
     * @param string $type
     * @param string $owner
     * @return mixed
     */
    public static function getRepositories($type = 'org', $owner = 'battleplugins') {
        $url = str_plural($type) . '/' . $owner . '/repos';
        $data = static::getFeed($url);
        return $data;
    }
}