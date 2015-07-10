<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use Auth;

class PageController extends Controller {

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index($current_job = null) {
        $stableBuilds = [];
        if ($current_job) {
            $current_job = Jenkins::getJobs($current_job);

            foreach($current_job->builds as $build){
                $build = Jenkins::getBuild($current_job->name, $build->number);
                if($build->result == 'SUCCESS')
                    $stableBuilds[] = $build;
            }
        }

        $jobs = Jenkins::getJobs();

        $latestBuilds = [];
        foreach ($jobs as $job) {
            $job = Jenkins::getJobs($job->name);

            if ($job->lastStableBuild)
                $latestBuilds[$job->name] = $job->lastStableBuild;
        }

        return view('download.index', [
            'jobs' => $jobs,
            'rssFeed' => Jenkins::getFeed('rssLatest'),
            'current_job' => $current_job,
            'latestBuilds' => $latestBuilds,
            'stableBuilds' => $stableBuilds
        ]);
    }

}
