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
        $url = ShortUrl::where('path', $path)->first();

        if ($url)
            return redirect($url->url);

        return redirect('/');
    }

    public function create(Request $request)
    {
        $req = $request->get('url');
        $req = Domain::stripTrailingSlash($req);

        if (!Domain::isUrl($req))
            return redirect('/')->with('error', 'Please enter a valid URL.');

        $url = ShortUrl::where('url', $req)->first();

        if (!$url) {
            $path = SlugGenerator::generate();

            ShortUrl::create([
                'url' => $req,
                'path' => $path
            ]);
        } else
            $path = $url->path;

        return redirect('/')->with('url_path', $path);
    }

}
