<?php namespace App\Http\Controllers\Paste;

use App\Http\Controllers\Controller;
use App\Tools\Misc\UserSettings;
use Auth;

class PageController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_PASTE)) {
            return view('paste.index', [
                'pastes' => auth()->user()->pastes
            ]);
        } else
            abort(403);
    }
}
