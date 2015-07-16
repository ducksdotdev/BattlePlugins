<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\ShortUrl;
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

    public function deleteShortUrl($url) {
        ShortUrl::wherePath($url)->delete();
        return redirect()->back();
    }
}