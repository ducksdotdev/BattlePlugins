<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\ProductionBuilds;
use Auth;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller {

    public function index($current_job = null) {
        $jobs = Jenkins::getJobs();

        $curr = null;
        if ($current_job)
            $curr = Jenkins::getJobs($current_job);

        $server_online = Cache::get('serverData');

        return view('download.index', [
            'jobs'          => $jobs,
            'current_job'   => $curr,
            'stableBuilds'  => Jenkins::getStableBuilds($current_job, 20),
            'production'    => new ProductionBuilds(),
            'server_online' => $server_online['servers'][0]['online']
        ]);
    }

}
