<?php namespace App\Http\Controllers\ShortUrls;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use App\Tools\URL\Domain;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller {

    public function index() {
        return view('shorturls.index');
    }

    public function redirect($slug) {
        $url = ShortUrl::whereSlug($slug)->first();

        if ($url) {
            ShortUrl::whereSlug($slug)->update([
                'last_used' => Carbon::now()
            ]);

            return redirect($url->url);
        }

        return abort(404);
    }

    public function create(Request $request) {
        if (!$request->has('url'))
            redirect()->back()->with('error', 'Please use a proper URL.');

        $req = $request->get('url');
        $slug = Domain::shorten($req);

        if (!$slug)
            redirect()->back()->with('error', 'Please make sure that URL exists.');

        return redirect()->back()->with('url_path', $slug);
    }
}
