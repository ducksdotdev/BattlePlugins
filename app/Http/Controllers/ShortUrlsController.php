<?php namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Tools\URL\Domain;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShortUrlsController extends Controller {

    public function getIndex() {
        return view('shorturls.index');
    }

    public function getRedirect($slug) {
        $url = ShortUrl::whereSlug($slug)->first();

        if ($url) {
            ShortUrl::whereSlug($slug)->update([
                'last_used' => Carbon::now()
            ]);

            return redirect($url->url);
        }

        return abort(404);
    }

    public function postCreate(Request $request) {
        $url = $request->get('url');

        if (!$url)
            redirect()->back()->with('error', 'Please use a proper URL.');

        $slug = Domain::shorten($url);

        if (!$slug)
            redirect()->back()->with('error', 'Please make sure that URL exists.');

        return redirect()->back()->with('url_path', $slug);
    }
}
