<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\ShortUrlTransformer;
use App\Tools\Models\ShortUrl;
use App\Tools\URL\Domain;
use App\Tools\URL\SlugGenerator;
use Auth;
use Illuminate\Http\Request;

class ShortUrlsController extends ApiController
{
    protected $shortUrlTransformer, $statusCode, $request;

    function __construct (ShortUrlTransformer $shortUrlTransformer, ApiStatusCode $statusCode, Request $request) {
        $this->middleware('auth.api');
        $this->shortUrlTransformer = $shortUrlTransformer;
        $this->statusCode = $statusCode;
        $this->request = $request;
    }

    public function index(){
        return $this->statusCode->respondNotFound();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() {
        $req = $this->request->get('url');
	    $req = Domain::stripTrailingSlash($req);

        if(!Domain::isUrl($req))
            return $this->statusCode->respondWithError('Please enter a valid URL.');

        $url = ShortUrl::whereUrl($req)->first();

        if(!$url) {
            $path = SlugGenerator::generate();

            ShortUrl::create([
                'url' => $req,
                'path' => $path
            ]);
        } else
            $path = $url->path;

        return $this->statusCode->respondCreated($path);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($url){
        $url = ShortUrl::whereUrl($url)->first();
        $url->delete();

        return $this->statusCode->respondWithSuccess("Short URL has been deleted.");
    }
}