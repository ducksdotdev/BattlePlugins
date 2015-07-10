<?php

namespace App\Tools\Misc;

use Awjudd\FeedReader\Facades\FeedReader;
use Illuminate\Support\Facades\Cache;

class Jenkins {

    public static function getFeed($endpoint = 'rssAll', $limit = 4, $start = 0) {
        $feed = FeedReader::read(env("JENKINS_URL") . '/' . $endpoint);
        $feed->enable_order_by_date();
        return $feed->get_items($start, $limit);
    }

    public static function getJobs($job = null) {
        if ($job)
            return Cache::pull($job . '_jobs');
        else
            return Cache::pull('_jobs');
    }

    public static function getBuild($job, $build) {
        return Cache::pull($job . '_' . $build);
    }

    public static function getStableBuilds($job = null, $limit = null, $start = 0) {
        $stableBuilds = [];

        foreach (static::getAllBuilds($job) as $build) {
            if ($build->result == 'SUCCESS')
                $stableBuilds[] = $build;
        }

        $stableBuilds = array_sort($stableBuilds, function ($value) {
            return -1 * $value->timestamp;
        });

        if ($limit)
            return array_slice($stableBuilds, $start, $limit);

        return $stableBuilds;
    }

    public static function getAllBuilds($job = null, $limit = null, $start = 0) {
        $builds = [];

        if ($job) {
            $job = Jenkins::getJobs($job);

            foreach ($job->builds as $build)
                array_push($builds, Jenkins::getBuild($job->name, $build->number));

        } else {
            foreach (static::getJobs() as $job) {
                $job = static::getJobs($job->name);

                foreach ($job->builds as $build)
                    $builds[] = static::getBuild($job->name, $build->number);
            }
        }

        $builds = array_sort($builds, function ($value) {
            return -1 * $value->timestamp;
        });

        if ($limit)
            return array_slice($builds, $start, $limit);

        return $builds;
    }

    public static function updateJob() {
        $url = '/api/json';
        $content = file_get_contents(env('JENKINS_URL') . $url);
        $content = json_decode($content);

        return $content->jobs;
    }

    public static function updateBuild($job, $build) {
        $url = env('JENKINS_URL') . '/job/' . $job . '/' . $build . '/api/json';
        return json_decode(file_get_contents($url));
    }

}