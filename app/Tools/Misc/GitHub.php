<?php


namespace App\Tools\Misc;


class GitHub {

    public static function getFeed($feed = 'battleplugins', $type = 'org', $limit = 5) {
        $url = 'https://api.github.com/' . str_plural($type) . '/' . $feed . '/events?client_id' . env('GITHUB_APP_ID') . '&client_secret=' . env('GITHUB_APP_SECRET');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'apache');
        $data = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($data);
        $returnData = [];
        for($i = 0; $i < $limit; $i++)
            $returnData[] = $data[$i];

        return $returnData;
    }

    public static function convertEvent($event) {
        return config('github.events.'.$event);
    }
    
}