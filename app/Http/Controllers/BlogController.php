<?php namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller {

	public function newPost (Request $request) {
		$title = $request->input('title');
		$content = $request->input('blogContent');
		$author = Auth::user()->id;

		Blog::create([
			'title' => $title,
			'content' => $content,
			'author' => $author
		]);

		return redirect('/');
	}

}
