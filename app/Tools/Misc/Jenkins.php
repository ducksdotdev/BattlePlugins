<?php

namespace App\Tools\Misc;

use App\Tools\Models\BuildDownloads;
use Awjudd\FeedReader\Facades\FeedReader;

class Jenkins {

    public static function getFeed($endpoint = 'rssAll', $limit = 4, $start = 0) {
        $feed = FeedReader::read(env("JENKINS_URL") . '/' . $endpoint);
        $feed->enable_order_by_date();
        return $feed->get_items($start, $limit);
    }

    public static function getJobs($job = null) {
        if ($job) {
            $path = storage_path() . "/jenkins/$job.json";
            if (file_exists($path))
                return json_decode(file_get_contents($path));
            else return null;
        } else {
            $path = storage_path() . "/jenkins/jobs.json";
            if (file_exists($path))
                return json_decode(file_get_contents($path));
            else return [];
        }
    }

    public static function getBuild($job, $build) {
        return json_decode(file_get_contents(storage_path() . "/jenkins/$job/$build.json"));
    }

    public static function getStableBuilds($job = null, $limit = null, $start = 0) {
        $stableBuilds = [];

        $builds = static::getAllBuilds($job);

        if ($builds) {
            foreach ($builds as $build) {
                if ($build->result == 'SUCCESS')
                    $stableBuilds[] = $build;
            }
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

            if ($job) {
                foreach ($job->builds as $build)
                    array_push($builds, Jenkins::getBuild($job->name, $build->number));
            }
        } else {
            $jobs = static::getJobs();
            foreach ($jobs as $job) {
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

    public static function getBuildVersion($job, $build) {
        $path = storage_path() . "/jenkins/$job/$build.xml";
        if (file_exists($path)) {
            $content = new \SimpleXMLElement(file_get_contents($path));
            $content = (string)$content->version;
        } else
            $content = static::getBuild($job, $build)->number;

        if (is_integer($content))
            return '#' . $content;

        return 'v' . $content . '-' . $build;
    }

    public static function downloadJar($build) {
        foreach ($build->artifacts as $artifact) {
            if (ends_with($artifact->fileName, '.jar')) {
                $downloads = BuildDownloads::firstOrCreate([
                    'build' => $build->fullDisplayName
                ]);
                $downloads->increment('downloads');

                return $build->url . 'artifact/' . $artifact->relativePath;
            }
        }

        return null;
    }

    public static function getDownloadCount($build) {
        $downloads = BuildDownloads::find($build->fullDisplayName);
        return $downloads ? $downloads->downloads : 0;
    }

    public static function getJobFromBuild($build) {
        return explode(' ', $build->fullDisplayName)[0];
    }

    public static function deleteBuild($job, $build) {
        delete(storage_path() . "/jenkins/$job/$build.json");
    }

}