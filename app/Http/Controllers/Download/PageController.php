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
        if($current_job)
            $current_job = Jenkins::getJobs($current_job);

        return view('download.index', [
            'jobs' => Jenkins::getJobs(),
            'rssFeed' => Jenkins::getFeed('rssLatest'),
            'current_job' => $current_job
        ]);
    }

}
