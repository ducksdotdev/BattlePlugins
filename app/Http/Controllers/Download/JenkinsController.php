<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Models\ProductionBuilds;
use Auth;
use Illuminate\Support\Facades\Cache;

class JenkinsController extends Controller {

    public function toggleProduction($job) {
        $jobid = ProductionBuilds::find($job);
        if ($jobid)
            $jobid->delete();
        else
            ProductionBuilds::create(['id' => $job]);

        return redirect()->back();
    }

    public function updateJobs($job, $build = null) {
        $key = $job . '_jobs';
        Cache::forget($key);
        Cache::forever($key, function () use ($job) {
            $url = '/job/' . $job . '/api/json';

            $content = file_get_contents(env('JENKINS_URL') . $url);
            $content = json_decode($content);

            return $content;
        });

        Cache::forget('_jobs');
        Cache::forever('_jobs', function () {
            $url = '/api/json';
            $content = file_get_contents(env('JENKINS_URL') . $url);
            $content = json_decode($content);

            return $content->jobs;
        });

        if ($build)
            static::updateBuild($job, $build);
    }

    public function updateBuild($job, $build) {
        $key = $job . '_' . $build;

        Cache::forget($key);
        Cache::forever($key, function () use ($job, $build) {
            $url = env('JENKINS_URL') . '/job/' . $job . '/' . $build . '/api/json';
            return json_decode(file_get_contents($url));
        });
    }

}
