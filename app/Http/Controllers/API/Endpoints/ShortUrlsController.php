<?php

namespace App\Http\Controllers\API\Endpoints;

use App\ShortUrl;
use App\Tools\Transformers\ShortUrlTransformer;
use Auth;
use App\Tools\StatusCodes\ApiStatusCode;
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

        if(!(starts_with($req, 'http://') || starts_with($req, 'https://')))
            return $this->statusCode->respondWithError('Please make sure your URL has http:// or https:// defined.');

        $url = ShortUrl::where('url', $req)->first();

        if(!$url) {
            $path = str_random(6);

            while(ShortUrl::where('path', $path)->first())
                $path = str_random(6);

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
        $url = ShortUrl::where('url', $url)->first();
        $url->delete();

        return $this->statusCode->respondWithSuccess("Short URL has been deleted.");
    }
}