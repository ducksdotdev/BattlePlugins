<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller {

	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function create () {
		$title = $this->request->input('title');
		$content = $this->request->input('content');
		$author = Auth::user()->id;

		$data = [
			'title' => $title,
			'content' => $content,
			'author' => $author
		];

		Webhooks::sendPayload('/blogs', 'POST', $data);

		return redirect('/');
	}

	public function deleteBlog($id){
		Webhooks::sendPayload('/blogs/' . $id, 'DELETE');
		return redirect('/');
	}

	public function editBlog($id){
		$title = $this->request->input('title');
		$content = $this->request->input('content');

		$data = [
			'title' => $title,
			'content' => $content,
		];

		Webhooks::sendPayload('/blogs/' . $id, 'PATCH', $data);

		return redirect('/blog/'.$id);
	}

}
