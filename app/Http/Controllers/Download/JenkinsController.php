<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
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
        Cache::forever($key, Jenkins::updateJobs($job));

        Cache::forget('_jobs');
        Cache::forever('_jobs', Jenkins::updateJobs());

        if ($build)
            static::updateBuild($job, $build);
    }

    public function updateBuild($job, $build) {
        $key = $job . '_' . $build;

        Cache::forget($key);
        Cache::forever($key, Jenkins::updateBuild($job, $build));

        $key = $job . '_' . $build . '_vers';
        Cache::forget($key);
        Cache::forever($key, Jenkins::updateBuildVersion($job, $build));
    }

}
