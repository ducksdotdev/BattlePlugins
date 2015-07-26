<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Jenkins\Jenkins;
use App\Jenkins\JenkinsJob;
use App\Models\ProductionBuilds;
use App\Tools\URL\Domain;
use Auth;

class PageController extends Controller {

    public function index($current_job = null) {
        if ($current_job) {
            $current_job = new JenkinsJob($current_job);
            $stableBuilds = $current_job->getStableBuilds(20);
        } else
            $stableBuilds = Jenkins::getStableBuilds(20);

        return view('download.index', [
            'jobs'          => Jenkins::getJobs(),
            'current_job'   => $current_job,
            'stableBuilds'  => $stableBuilds,
            'production'    => new ProductionBuilds(),
            'server_online' => Domain::remoteFileExists('http://ci.battleplugins.com')
        ]);
    }

    public function getLatestVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $job = new JenkinsJob($job);
        return response($job->getStableBuilds()[0]->getVersionImage($w, $h, $font_size), 200, ['Content-Type' => 'image/png']);
    }

    public function getLatestStableVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $job = new JenkinsJob($job);
        foreach ($job->getStableBuilds() as $build) {
            if ($build->isStable())
                return response($build->getVersionImage($w, $h, $font_size), 200, ['Content-Type' => 'image/png']);
        }

        return null;
    }

}
