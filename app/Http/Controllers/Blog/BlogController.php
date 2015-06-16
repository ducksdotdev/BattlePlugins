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

        Blog::create([
			'title' => $title,
			'content' => $content,
			'author' => Auth::user()->id
        ]);

        return redirect('/');
	}

	public function deleteBlog($id){
        Blog::find($id)->delete();
        return redirect('/');
	}

	public function editBlog($id){
		$title = $this->request->input('title');
		$content = $this->request->input('content');

        Blog::find($id)->update([
			'title' => $title,
			'content' => $content,
        ]);

		return redirect('/blog/'.$id);
	}

}
