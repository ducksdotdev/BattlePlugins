<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Tools\API\Transformers\BlogTransformer;
use App\Tools\Models\Blog;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller {

    private $request, $webhooks, $blogTransformer;

    public function __construct(Request $request, Webhooks $webhooks, BlogTransformer $blogTransformer)
    {
		$this->request = $request;
        $this->webhooks = $webhooks;
        $this->blogTransformer = $blogTransformer;
	}

	public function create () {
		$title = $this->request->input('title');
		$content = $this->request->input('content');
		$author = Auth::user()->id;

        $blog = Blog::create([
			'title' => $title,
			'content' => $content,
			'author' => $author
        ]);

        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_CREATED);

        return redirect('/');
	}

	public function deleteBlog($id){
        $blog = Blog::find($id);

        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_DELETED);

        $blog->delete();

        return redirect('/');
	}

	public function editBlog($id){
		$title = $this->request->input('title');
		$content = $this->request->input('content');

        $blog = Blog::find($id);
        $blog->update([
			'title' => $title,
			'content' => $content,
        ]);

        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_MODIFIED);

		return redirect('/blog/'.$id);
	}

}
