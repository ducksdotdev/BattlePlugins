<?php namespace App\Http\Controllers\ShortUrls;

use App\Http\Controllers\Controller;
use Auth;

class PageController extends Controller {

    public function index() {
        return view('shorturls.index');
    }

    public function redirect($path) {
        $url = ShortUrl::wherePath($path)->first();

        if ($url && Domain::remoteFileExists($url->url))
            return redirect($url->url);
        elseif ($url && !Domain::remoteFileExists($url->url))
            ShortUrl::wherePath($path)->delete();

        return abort(404);
    }

    public function create(Request $request) {
        if (!$request->has('url'))
            redirect()->back()->with('error', 'Please use a proper URL.');

        $req = $request->get('url');
        $path = Domain::shorten($req);

        if (!$path)
            redirect()->back()->with('error', 'Please make sure that URL exists.');

        return redirect()->back()->with('url_path', $path);
    }
}
