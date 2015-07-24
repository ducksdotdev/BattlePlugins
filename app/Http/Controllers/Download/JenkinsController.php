<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateJobs;
use App\Models\ProductionBuilds;
use App\Tools\Misc\Jenkins;
use App\Tools\URL\Domain;
use Auth;
use Illuminate\Support\Facades\Log;

class JenkinsController extends Controller {

    public function toggleProduction($job) {
        $jobid = ProductionBuilds::find($job);
        if ($jobid)
            $jobid->delete();
        else
            ProductionBuilds::create(['build' => $job]);

        return redirect()->back();
    }

    public function updateJenkins($event = "Manual") {
        Log::info("Updating Jenkins Jobs from webhook event: $event");

        if (Domain::remoteFileExists("http://ci.battleplugins.com"))
            $this->dispatch(new UpdateJobs());
        else
            return "The CI server is offline.";
    }

    public function download($job, $build) {
        $download = Jenkins::downloadJar($job, $build);

        if ($download)
            return redirect($download);

        $this->dispatch(new UpdateJobs());
        return redirect()->back();
    }
}
