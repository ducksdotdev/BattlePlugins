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

    public static function getStableBuilds($job = null) {
        $stableBuilds = [];

        if ($job) {
            $job = Jenkins::getJobs($job);

            foreach ($job->builds as $build) {
                $build = Jenkins::getBuild($job->name, $build->number);
                if ($build->result == 'SUCCESS')
                    $stableBuilds[] = $build;
            }
        } else {
            foreach (static::getJobs() as $job) {
                $job = static::getJobs($job->name);

                if ($job->lastStableBuild) {
                    $build = static::getBuild($job->name, $job->lastStableBuild->number);
                    if ($build->result == 'SUCCESS')
                        $stableBuilds[] = $build;
                }
            }
        }

        return array_sort($stableBuilds, function ($value) {
            return -1 * $value->timestamp;
        });
    }

}