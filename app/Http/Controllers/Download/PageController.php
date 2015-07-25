<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Models\ProductionBuilds;
use App\Tools\Misc\Jenkins;
use App\Tools\URL\Domain;
use Auth;

class PageController extends Controller {

    public function index($current_job = null) {
        return view('download.index', [
            'jobs'          => Jenkins::getJobs(),
            'current_job'   => $current_job ? Jenkins::getJobs($current_job) : null,
            'stableBuilds'  => Jenkins::getStableBuilds($current_job, 20),
            'production'    => new ProductionBuilds(),
            'server_online' => Domain::remoteFileExists('http://ci.battleplugins.com')
        ]);
    }

    public function getLatestVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $build = Jenkins::getAllBuilds($job);
        $img = Jenkins::getVersionImage($job, $build, $w, $h, $font_size);
        return response($img, 200, ['Content-Type' => 'image/png']);
    }

    public function getLatestStableVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $build = Jenkins::getStableBuilds($job);
        $img = Jenkins::getVersionImage($job, $build, $w, $h, $font_size);
        return response($img, 200, ['Content-Type' => 'image/png']);
    }

}
