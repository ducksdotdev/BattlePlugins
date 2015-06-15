<?php namespace App\Http\Controllers\ShortUrls;

use App\Http\Controllers\Controller;
use Auth;

class PageController extends Controller
{

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::check())
            return view('shorturls.index');
        else
            return view('shorturls.login');
    }
}
