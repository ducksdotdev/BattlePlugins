<?php

namespace App\Jobs;

use App\Jenkins\JenkinsBuild;
use App\Tools\URL\Domain;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateBuild extends Job implements SelfHandling {
    /**
     * @var
     */
    private $build;

    /**
     * Create a new job instance.
     *
     * @param $job
     * @param $build
     */
    public function __construct(JenkinsBuild $build) {
        $this->build = $build;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        if (Domain::remoteFileExists("http://ci.battleplugins.com")) {
            $jobName = $this->build->getJob()->getName();
            $buildNum = $this->build->getBuild();

            $url = env('JENKINS_URL') . '/job/' . $jobName . '/' . $buildNum . '/api/json';
            $content = file_get_contents($url);

            $path = storage_path() . "/jenkins/" . $jobName . "/";
            if (!is_dir($path))
                mkdir($path, 0777, true);

            file_put_contents($path . $buildNum . ".json", $content);

            $url = env('JENKINS_URL') . '/job/' . $jobName . '/' . $buildNum . '/artifact/pom.xml';
            if (Domain::remoteFileExists($url)) {
                $content = file_get_contents($url);
                file_put_contents($path . $buildNum . ".xml", $content);
            }
        }
    }
}
