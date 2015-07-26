<?php


namespace App\Jenkins;


/**
 * Class JenkinsJob
 * @package App\Jenkins
 */
class JenkinsJob {

    /**
     * @var
     */
    private $name;

    /**
     * @param $name
     */
    function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getData() {
        $path = storage_path() . "/jenkins/$this->name.json";
        if (file_exists($path))
            return json_decode(file_get_contents($path));

        return null;
    }

    /**
     * @param $build
     * @return JenkinsBuild
     */
    public function getBuild($build) {
        return new JenkinsBuild($this, $build->number);
    }

    /**
     * @param null $limit
     * @param int $start
     * @return array
     */
    public function getAllBuilds($limit = null, $start = 0) {
        $builds = [];

        foreach ($this->getData()->builds as $build)
            array_push($builds, $this->getBuild($build));

        $builds = array_sort($builds, function ($value) {
            if ($value->getData())
                return -1 * $value->getData()->timestamp;
        });

        if ($limit)
            return array_slice($builds, $start, $limit);

        return $builds;
    }

    /**
     * @param null $limit
     * @param int $start
     * @return array
     */
    public function getStableBuilds($limit = null, $start = 0) {
        $stableBuilds = [];

        $builds = $this->getAllBuilds();

        if ($builds) {
            foreach ($builds as $build) {
                if ($build->getData()->result == 'SUCCESS')
                    $stableBuilds[] = $build;
            }
        }

        $stableBuilds = array_sort($stableBuilds, function ($value) {
            return -1 * $value->getData()->timestamp;
        });

        if ($limit)
            return array_slice($stableBuilds, $start, $limit);

        return $stableBuilds;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }
}