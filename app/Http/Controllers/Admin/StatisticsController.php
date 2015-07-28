<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use App\Tools\Misc\UserSettings;
use Auth;
use Illuminate\Http\Request;

class StatisticsController extends Controller {

    private $request;

    /**
     * @param Request $request
     */
    function __construct(Request $request) {
        $this->middleware('auth.admin');
        $this->request = $request;
    }

    public function deleteShortUrl($slug) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_SHORTURL)) {
            ShortUrl::whereSlug($slug)->delete();
            return redirect()->back();
        }
    }
}