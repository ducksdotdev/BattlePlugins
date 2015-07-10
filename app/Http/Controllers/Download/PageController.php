<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\ProductionBuilds;
use Auth;

class PageController extends Controller {

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index($current_job = null) {
        $stableBuilds = [];
        $jobs = Jenkins::getJobs();
        if ($current_job) {
            $current_job = Jenkins::getJobs($current_job);

            foreach ($current_job->builds as $build) {
                $build = Jenkins::getBuild($current_job->name, $build->number);
                if ($build->result == 'SUCCESS')
                    $stableBuilds[] = $build;
            }
        } else {
            foreach ($jobs as $job) {
                $job = Jenkins::getJobs($job->name);

                if ($job->lastStableBuild) {
                    $build = Jenkins::getBuild($job->name, $job->lastStableBuild->number);
                    if ($build->result == 'SUCCESS')
                        $stableBuilds[] = $build;
                }
            }
        }

        array_sort($stableBuilds, function ($value) {
            return $value->timestamp;
        });

        return view('download.index', [
            'jobs' => $jobs,
            'rssFeed' => Jenkins::getFeed('rssLatest'),
            'current_job' => $current_job,
            'stableBuilds' => $stableBuilds,
            'production' => new ProductionBuilds()
        ]);
    }

    public function toggleProduction($job) {
        $jobid = ProductionBuilds::find($job);
        if($jobid)
            $jobid->delete();
        else
            ProductionBuilds::create(['id'=>$job]);

        return redirect()->back();
    }

}
