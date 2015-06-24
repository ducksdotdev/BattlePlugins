<?php namespace App\Http\Controllers\ShortUrls;

use App\Http\Controllers\Controller;
use App\Tools\Models\ShortUrl;
use App\Tools\URL\Domain;
use Auth;
use Illuminate\Http\Request;

class UrlController extends Controller
{

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function redirect($path)
    {
        $url = ShortUrl::wherePath($path)->first();

        if ($url)
            return redirect($url->url);

        return abort(404);
    }

    public function create(Request $request)
    {
        if(!$request->has('url'))
            redirect('/')->with('error', 'Please use a proper URL.');

        $req = $request->get('url');
        $path = Domain::shorten($req);

        if(!$path)
            redirect('/')->with('error', 'Please use a proper URL.');

        return redirect('/')->with('url_path', $path);
    }

}
