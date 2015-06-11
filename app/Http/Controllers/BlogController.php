<?php namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller {

	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function newBlog () {
		$title = $this->request->input('title');
		$content = $this->request->input('content');
		$author = Auth::user()->id;

		Blog::create([
			'title' => $title,
			'content' => $content,
			'author' => $author
		]);

		return redirect('/');
	}

	public function deleteBlog($blog){
		Blog::find($blog)->delete();
		return redirect('/');
	}

	public function editBlog($blog){
		$title = $this->request->input('title');
		$content = $this->request->input('content');

		Blog::find($blog)->update([
			'title' => $title,
			'content' => $content,
		]);

		return redirect('/blog/'.$blog);
	}

}
