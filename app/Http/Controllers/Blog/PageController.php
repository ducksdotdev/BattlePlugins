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
        $blog = Blog::latest()->first();

        if (!$blog)
            return view('blog.index');

        return view('blog.index', $this->retrieve($blog));
    }

    private function retrieve(Blog $blog)
    {

        $users = User::all();
        $displaynames = [];

        foreach ($users as $user)
            $displaynames[$user->id] = $user->displayname;

        return [
            'blog' => $blog,
            'list' => Blog::latest()->take(4)->get(),
            'author' => $displaynames[$blog->author],
            'users' => $displaynames
        ];
    }

    public function getBlog($id)
    {
        $blog = Blog::whereId($id);

        if (!$blog)
            return view('blog.index');

        return view('blog.index', $this->retrieve($blog));
    }

}