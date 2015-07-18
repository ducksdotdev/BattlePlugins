<?php namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\ProductionBuilds;
use App\Tools\URL\Domain;
use Auth;
use Intervention\Image\Facades\Image;

class PageController extends Controller {

    public function index($current_job = null) {
        $jobs = Jenkins::getJobs();

        $curr = null;
        if ($current_job)
            $curr = Jenkins::getJobs($current_job);

        return view('download.index', [
            'jobs'          => $jobs,
            'current_job'   => $curr,
            'stableBuilds'  => Jenkins::getStableBuilds($current_job, 20),
            'production'    => new ProductionBuilds(),
            'server_online' => Domain::remoteFileExists('http://ci.battleplugins.com')
        ]);
    }

    public function getLatestVersionImage($job, $w = 130, $h = 50, $font_size = 20) {
        $build = Jenkins::getStableBuilds($job);

        if ($build)
            $vers = Jenkins::getBuildVersion($job, $build[0]->number);
        else
            $vers = 'null';

        $img = Image::canvas($w, $h)->text($vers, 15, 15, function ($font) use ($font_size) {
            $font->file('../public/assets/fonts/tenby-five.otf');
            $font->size($font_size);
            $font->valign('top');
        })->encode('png');

        return response($img, 200, ['Content-Type' => 'image/png']);
    }

}
