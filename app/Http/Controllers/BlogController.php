<?php namespace App\Http\Controllers;

use App\Tools\Webhooks;
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
