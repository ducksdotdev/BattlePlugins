<?php

namespace App\Jobs;

use App\Tools\URL\Domain;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateBuild extends Job implements SelfHandling {
    /**
     * @var
     */
    private $job;
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
    public function __construct($job, $build) {
        $this->job = $job;
        $this->build = $build;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $url = env('JENKINS_URL') . '/job/' . $this->job . '/' . $this->build . '/api/json';
        $content = file_get_contents($url);

        $path = storage_path() . "/jenkins/$this->job/";
        if (!is_dir($path))
            mkdir($path, 0777, true);

        file_put_contents($path . $this->build . ".json", $content);

        $url = env('JENKINS_URL') . '/job/' . $this->job . '/' . $this->build . '/artifact/pom.xml';
        if (Domain::remoteFileExists($url)) {
            $content = file_get_contents($url);
            file_put_contents($path . $this->build . ".xml", $content);
        }
    }
}
