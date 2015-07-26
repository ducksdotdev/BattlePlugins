<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Jenkins\Jenkins;
use App\Models\Blog;
use App\Tools\Misc\Settings;
use App\Tools\URL\Domain;

class PageController extends Controller {

    public function index($id = null) {
        if ($id)
            $blog = Blog::find($id);
        else
            $blog = Blog::latest()->first();

        return view('blog.index', [
            'blog' => $blog,
            'list' => Blog::latest()->take(4)->get(),
            'jenkins' => Settings::get('jenkins') ? Jenkins::getStableBuilds(null, 4) : null,
            'download_server' => Domain::remoteFileExists('http://ci.battleplugins.com'),
            'comment_feed' => Settings::get('comment_feed')
        ]);
    }
}