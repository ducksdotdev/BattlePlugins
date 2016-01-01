<?php


namespace App\Jenkins;


    /**
     * Class JenkinsJob
     * @package App\Jenkins
     */
    /**
     * Class JenkinsJob
     * @package App\Jenkins
     */
/**
 * Class JenkinsJob
 * @package App\Jenkins
 */
class JenkinsJob {

    private $name;
    private $path;

    /**
     * @param $name
     */
    function __construct($name) {
        $this->name = $name;
        $this->path = storage_path() . "/jenkins/$name.json";
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
     * @param null $limit
     * @param int $start
     * @return array
     */
    public function getAllBuilds($limit = null, $start = 0) {
        $builds = [];

        if (!is_array($this->getData()))
            return [];

        if (array_key_exists('builds', $this->getData())) {
            foreach ($this->getData()->builds as $build)
                array_push($builds, $this->getBuild($build));
        }

        $builds = array_sort($builds, function ($value) {
            if ($value->getData())
                return -1 * $value->getData()->timestamp;
        });

        if ($limit)
            return array_slice($builds, $start, $limit);

        return $builds;
    }

    /**
     * @return mixed|null
     */
    public function getData() {
        if (static::exists())
            return json_decode(file_get_contents($this->path));

        return null;
    }

    /**
     * @return bool
     */
    public function exists() {
        return file_exists($this->path);
    }

    /**
     * @param $build
     * @return JenkinsBuild
     */
    public function getBuild($build) {
        return new JenkinsBuild($this, $build->number);
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getColor() {
        return static::getData()->color;
    }
}