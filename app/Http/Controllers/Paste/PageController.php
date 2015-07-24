<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use Auth;

class PageController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('paste.index', [
            'pastes' => auth()->user()->pastes
        ]);
    }

}
