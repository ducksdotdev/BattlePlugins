<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Tools\API\Transformers\BlogTransformer;
use App\Tools\Misc\UserSettings;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller {

    private $request, $webhooks, $blogTransformer;

    public function __construct(Request $request, Webhooks $webhooks, BlogTransformer $blogTransformer) {
        $this->request = $request;
        $this->webhooks = $webhooks;
        $this->blogTransformer = $blogTransformer;
    }

    public function create() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_BLOG)) {
            $title = $this->request->input('title');
            $content = $this->request->input('content');

            Blog::create([
                'title' => $title,
                'content' => $content,
                'author' => Auth::user()->id
            ]);

            return redirect()->back();
        } else
            abort(403);
    }

    public function deleteBlog($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_BLOG)) {
            Blog::find($id)->delete();
            return redirect()->back();
        } else
            abort(403);
    }

    public function editBlog($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_BLOG)) {
            $title = $this->request->input('title');
            $content = $this->request->input('content');

            $blog = Blog::whereId($id);

            if (!$blog)
                return redirect("/");

            $blog->update([
                'title' => $title,
                'content' => $content,
            ]);

            return redirect('/' . $id);
        } else
            abort(403);
    }
}
