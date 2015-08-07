<?php namespace App\Http\Controllers;

use App\Jenkins\Jenkins;
use App\Jenkins\JenkinsBuild;
use App\Jenkins\JenkinsJob;
use App\Models\ProductionBuilds;
use App\Tools\Domain;
use Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class DownloadController
 * @package App\Http\Controllers\Download
 */
class DownloadController extends Controller {

    /**
     * @param null $current_job
     * @return \Illuminate\View\View
     */
    public function getIndex($current_job = null) {
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

    /**
     * @param $job
     * @param int $w
     * @param int $h
     * @param int $font_size
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getLatestVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $job = new JenkinsJob($job);
        return response($job->getStableBuilds()[0]->getVersionImage($w, $h, $font_size), 200, ['Content-Type' => 'image/png']);
    }

    /**
     * @param $job
     * @param int $w
     * @param int $h
     * @param int $font_size
     * @return \Illuminate\Contracts\Routing\ResponseFactory|null|\Symfony\Component\HttpFoundation\Response
     */
    public function getLatestStableVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $job = new JenkinsJob($job);
        foreach ($job->getStableBuilds() as $build) {
            if ($build->isStable())
                return response($build->getVersionImage($w, $h, $font_size), 200, ['Content-Type' => 'image/png']);
        }

        return null;
    }

    /**
     * @param $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postToggleProduction($job) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MANAGE_BUILDS)) {
            $jobid = ProductionBuilds::find($job);
            if ($jobid)
                $jobid->delete();
            else
                ProductionBuilds::create(['build' => $job]);

            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param string $event
     * @return string
     */
    public function anyUpdateJenkins($event = "Manual") {
        Log::info("Updating Jenkins Jobs from webhook event: $event");

        if (Domain::remoteFileExists("http://ci.battleplugins.com"))
            $this->dispatch(new UpdateJobs());
        else
            return "The CI server is offline.";
    }

    /**
     * @param $job
     * @param $build
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getDownload($job, $build) {
        $build = new JenkinsBuild($job, $build);
        return redirect($build->downloadPlugin());
    }

}
