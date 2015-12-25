<?php namespace App\Http\Controllers;

use App\Jenkins\Jenkins;
use App\Models\Blog;
use App\Tools\Domain;
use App\Tools\Settings;
use Illuminate\Http\Request;

/**
 * Class BlogController
 * @package App\Http\Controllers\Blog
 */
class BlogController extends Controller {

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param null $id
     * @return \Illuminate\View\View
     */
    public function getIndex($id = null) {
        if ($id)
            $blog = Blog::find($id);
        else
            $blog = Blog::latest()->first();

        return view('blog.index', [
            'blog'         => $blog,
            'list'         => Blog::latest()->take(4)->get(),
            'jenkins'      => Settings::get('jenkins') ? Jenkins::getStableBuilds(4) : null,
            'download_server' => Domain::remoteFileExists('http://ci.battleplugins.com'),
            'comment_feed' => Settings::get('comment_feed')
        ]);
    }
}