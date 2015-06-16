<?php namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Tools\Models\Blog;
use App\Tools\Models\User;

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

    public function getBlog($id)
    {
        $blog = Blog::find($id);

        if (!$blog)
            return view('blog.index');

        $users = User::all();
        $displaynames = [];

        foreach ($users as $user)
            $displaynames[$user->id] = $user->displayname;

        return view('blog.index', [
            'blog' => $blog,
            'list' => Blog::latest()->take(4)->get(),
            'author' => $displaynames[$blog->author],
            'users' => $displaynames
        ]);
    }

}
