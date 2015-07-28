<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Models\ShortUrl;
use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\ShortUrlTransformer;
use App\Tools\Misc\UserSettings;
use App\Tools\URL\Domain;
use Auth;
use Illuminate\Http\Request;

class ShortUrlsController extends ApiController {
    protected $shortUrlTransformer, $statusCode, $request;

    function __construct(ShortUrlTransformer $shortUrlTransformer, ApiStatusCode $statusCode, Request $request) {
        $this->middleware('auth.api');
        $this->shortUrlTransformer = $shortUrlTransformer;
        $this->statusCode = $statusCode;
        $this->request = $request;
    }

    public function index() {
        return $this->statusCode->respondNotFound();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() {
        $req = $this->request->get('url');

        if (!$this->request->has('url') || !Domain::isUrl($req))
            return $this->statusCode->respondWithError("Please enter a proper URL.");

        $slug = Domain::shorten($req);
        if (!$slug)
            return $this->statusCode->respondWithError("Please enter a proper URL.");

        return $this->statusCode->respondCreated($slug);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($url) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_SHORTURL)) {
            $url = ShortUrl::whereUrl($url)->first();
            $url->delete();

            return $this->statusCode->respondWithSuccess("Short URL has been deleted.");
        } else
            return $this->statusCode->respondValidationFailed();
    }
}