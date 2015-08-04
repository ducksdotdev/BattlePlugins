<?php namespace App\Http\Controllers;

use App\Jenkins\Jenkins;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Tools\Domain;
use App\Tools\Settings;
use App\Tools\UserSettings;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateBlog() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_BLOG)) {
            BlogRepository::create($this->request->input('title'), $this->request->input('content'), auth()->user());
            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteBlog($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_BLOG)) {
            BlogRepository::delete($id);
            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditBlog($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_BLOG)) {
            $title = $this->request->input('title');
            $content = $this->request->input('content');
            $blog = Blog::find($id);

            if (!$blog)
                return redirect("/");

            BlogRepository::update($blog, [
                'title' => $title,
                'content' => $content,
            ]);

            return redirect('/' . $id);
        } else
            abort(403);
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
            'blog' => $blog,
            'list' => Blog::latest()->take(4)->get(),
            'jenkins' => Settings::get('jenkins') ? Jenkins::getStableBuilds(null, 4) : null,
            'download_server' => Domain::remoteFileExists('http://ci.battleplugins.com'),
            'comment_feed' => Settings::get('comment_feed')
        ]);
    }
}