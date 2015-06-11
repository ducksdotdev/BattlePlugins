<?php namespace App\Http\Controllers;

use App\Blog;
use App\User;
use Carbon\Carbon;

class PageController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$blog = Blog::orderby('created_at', 'desc')->first();

		if($blog)
			$carbon = new Carbon($blog->created_at);
		else
			return view('index', ['blog'=>false]);

		$users = User::all();
		$displaynames = [];

		foreach($users as $user){
			$displaynames[$user->id] = $user->displayname;
		}

		return view('index',
			[
				'blog' => $blog,
				'list' => Blog::orderby('created_at', 'desc')->take(4)->get(),
				'author' => User::find($blog->author)->pluck('displayname'),
				'created_at' => $carbon->diffForHumans(),
				'users' => $displaynames
			]);
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

		return view('index',
			[
				'blog' => $blog,
				'list' => Blog::orderby('created_at', 'desc')->take(4)->get(),
				'author' => User::find($blog->author)->pluck('displayname'),
				'created_at' => $carbon->diffForHumans(),
				'users' => $displaynames
			]);
	}

}
