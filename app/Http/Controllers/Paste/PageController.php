<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Tools\Models\Paste;
use Auth;

class PageController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $pastes = Paste::whereCreator(Auth::user()->id)->latest()->get();

        return view('paste.index', [
            'pastes' => $pastes
        ]);
    }

}
