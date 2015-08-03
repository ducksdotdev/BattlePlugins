<?php


namespace App\Jenkins;


use App\Models\BuildDownloads;
use App\Models\ProductionBuilds;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

/**
 * Class JenkinsBuild
 * @package App\Jenkins
 */
class JenkinsBuild {

    /**
     * @var JenkinsJob
     */
    private $job;
    /**
     * @var
     */
    private $build;

    /**
     * @param $job
     * @param $build
     */
    function __construct($job, $build) {
        if (!($job instanceof JenkinsJob))
            $job = new JenkinsJob($job);

        $this->job = $job;
        $this->build = $build;
    }

    /**
     * @param $w
     * @param $h
     * @param $font_size
     * @return Image
     */
    public function getVersionImage($w, $h, $font_size) {
        $vers = $this->getVersion();

        $img = Image::canvas($w, $h)->text($vers, 15, 15, function ($font) use ($font_size) {
            $font->file('../public/assets/fonts/tenby-five.otf');
            $font->size($font_size);
            $font->valign('top');
        })->encode('png');

        return $img;
    }

    /**
     * @return string
     */
    public function getVersion() {
        $path = storage_path() . "/jenkins/" . $this->job->getName() . "/$this->build.xml";

        if (file_exists($path)) {
            $content = new \SimpleXMLElement(file_get_contents($path));
            $content = (string)$content->version;
        } else
            $content = $this->getData()->number;

        if (is_integer($content))
            return '#' . $content;

        return 'v' . $content . '-' . $this->build;
    }

    /**
     * @return mixed
     */
    public function getData() {
        $file = storage_path() . "/jenkins/" . $this->job->getName() . "/$this->build.json";

        if (file_exists($file)) {
            $json_decode = json_decode(file_get_contents($file));
            return $json_decode;
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function downloadPlugin() {
        foreach ($this->getData()->artifacts as $artifact) {
            if (ends_with($artifact->fileName, '.jar')) {
                $downloads = BuildDownloads::firstOrCreate([
                    'build' => $this->getData()->fullDisplayName
                ]);
                $downloads->increment('downloads');

                return $this->getData()->url . 'artifact/' . $artifact->relativePath;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getDownloadUrl() {
        return action('DownloadController@getDownload', ['job' => $this->getJob()->getName(), 'build' => $this->getBuild()]);
    }

    /**
     * @return JenkinsJob
     */
    public function getJob() {
        return $this->job;
    }

    /**
     * @return mixed
     */
    public function getBuild() {
        return $this->build;
    }

    /**
     * @return mixed
     */
    public function getDownloadCount() {
        $dl = BuildDownloads::whereBuild($this->getData()->fullDisplayName)->pluck('downloads');
        if ($dl)
            return $dl;

        return 0;
    }

    /**
     * @return static
     */
    public function createdAt() {
        $timestamp = $this->getData()->timestamp;
        return Carbon::createFromTimestampUTC(str_limit($timestamp, 10));
    }

    /**
     * @return mixed
     */
    public function isStable() {
        return ProductionBuilds::find($this->getData()->timestamp);
    }
}