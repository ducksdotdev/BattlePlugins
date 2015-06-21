<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Tools\Models\Paste;
use Auth;

class PageController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::check()) {
            $pastes = Paste::whereCreator(Auth::user()->id)->latest()->get();

            return view('paste.index', [
                'pastes' => $pastes
            ]);
        } else
            return view('paste.login');
    }

}
