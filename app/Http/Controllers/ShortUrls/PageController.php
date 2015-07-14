<?php namespace App\Http\Controllers\ShortUrls;

use App\Http\Controllers\Controller;
use App\Tools\Models\ShortUrl;
use App\Tools\URL\Domain;
use Auth;
use Illuminate\Http\Request;

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
            view('shorturls.index', ['error'=>'Please use a proper URL.']);

        $req = $request->get('url');
        $path = Domain::shorten($req);

        if (!$path || !Domain::remoteFileExists($req))
            view('shorturls.index', ['error'=>'Please make sure that URL exists.']);

        return view('shorturls.index', ['url_path'=>$path]);
    }
}
