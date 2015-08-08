<?php namespace App\Http\Controllers;

use App\Repositories\ShortUrlRepository;
use App\Tools\Domain;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class ShortUrlsController
 * @package App\Http\Controllers
 */
class ShortUrlsController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        return view('shorturls.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function getRedirect($slug) {
        $url = ShortUrlRepository::getBySlug($slug);

        if ($url) {
            ShortUrlRepository::update($slug, [
                'last_used' => Carbon::now()
            ]);

            return redirect($url->url);
        }

        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
