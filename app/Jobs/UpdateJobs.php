<?php

namespace App\Jobs;

use App\Tools\Misc\Jenkins;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;

class UpdateJobs extends Job implements SelfHandling {
    use DispatchesJobs;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Log::info("Updating Jenkins Jobs");

        $path = storage_path() . "/jenkins/";
        if (is_dir($path))
            exec("rm -fdr $path");

        mkdir($path, 0777, true);

        $url = env('JENKINS_URL') . '/api/json';
        $content = json_decode(file_get_contents($url))->jobs;
        file_put_contents($path . "jobs.json", json_encode($content));

        foreach ($content as $job) {
            $url = env('JENKINS_URL') . '/job/' . $job->name . '/api/json';
            $job_content = file_get_contents($url);
            file_put_contents($path . $job->name . ".json", $job_content);

            foreach (Jenkins::getJobs($job->name)->builds as $build)
                $this->dispatch(new UpdateBuild($job->name, $build->number));
        }
    }
}
