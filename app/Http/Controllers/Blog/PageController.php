<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Tools\Models\Blog;
use App\Tools\Models\User;
use Carbon\Carbon;

class PageController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$blog = Blog::latest()->first()->id;
		return $this->getBlog($blog);
	}

	public function getBlog($blog){
		$blog = Blog::find($blog);

		if($blog)
			$carbon = new Carbon($blog->created_at);
		else return redirect('/');

		$users = User::all();
		$displaynames = [];

		foreach($users as $user){
			$displaynames[$user->id] = $user->displayname;
		}

		return view('blog.index',
			[
				'blog' => $blog,
				'list' => Blog::latest()->take(4)->get(),
				'author' => User::find($blog->author)->pluck('displayname'),
				'created_at' => $carbon->diffForHumans(),
				'users' => $displaynames
			]);
	}

}
