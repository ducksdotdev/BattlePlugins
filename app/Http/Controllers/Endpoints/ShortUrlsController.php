<?php

namespace App\Http\Controllers\Endpoints;

use App\API\StatusCodes\ApiStatusCode;
use App\API\Transformers\ShortUrlTransformer;
use App\Repositories\ShortUrlRepository;
use App\Tools\Domain;
use App\Tools\UserSettings;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ShortUrlsController
 * @package App\Http\Controllers\Endpoints
 */
class ShortUrlsController extends ApiController {
    /**
     * @var ShortUrlTransformer
     */
    /**
     * @var ApiStatusCode|ShortUrlTransformer
     */
    /**
     * @var ApiStatusCode|ShortUrlTransformer|Request
     */
    protected $shortUrlTransformer, $statusCode, $request;

    /**
     * @param ShortUrlTransformer $shortUrlTransformer
     * @param ApiStatusCode $statusCode
     * @param Request $request
     */
    function __construct(ShortUrlTransformer $shortUrlTransformer, ApiStatusCode $statusCode, Request $request) {
        $this->middleware('auth.api', ['except' => ['index', 'store']]);
        $this->shortUrlTransformer = $shortUrlTransformer;
        $this->statusCode = $statusCode;
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
     * @param $url
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($url) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_SHORTURL)) {
            ShortUrlRepository::deleteByUrl($url);
            return $this->statusCode->respondWithSuccess("Short URL has been deleted.");
        } else
            return $this->statusCode->respondValidationFailed();
    }
}