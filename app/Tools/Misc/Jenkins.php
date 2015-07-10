<?php

namespace App\Tools\Misc;

use Awjudd\FeedReader\Facades\FeedReader;

class Jenkins {

    public static function getFeed($endpoint = 'rssAll', $limit = 4, $start = 0) {
        $feed = FeedReader::read(env("JENKINS_URL") . '/' . $endpoint);
        $feed->enable_order_by_date();
        return $feed->get_items($start, $limit);
    }

    public static function getJobs($job = null) {
        if ($job) {
            $url = '/job/' . $job . '/api/json';

            $content = file_get_contents(env('JENKINS_URL') . $url);
            $content = json_decode($content);

            return $content;
        } else {
            $url = '/api/json';
            $content = file_get_contents(env('JENKINS_URL') . $url);
            $content = json_decode($content);

            return $content->jobs;
        }
    }

    public static function getBuild($job, $build) {
        $url = env('JENKINS_URL') . '/job/' . $job . '/' . $build . '/api/json';
        return json_decode(file_get_contents($url));
    }

}