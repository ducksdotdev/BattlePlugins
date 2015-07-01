<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\PasteTransformer;
use App\Tools\Models\Paste;
use App\Tools\Models\ShortUrl;
use App\Tools\URL\SlugGenerator;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class PastesController extends ApiController {
    /**
     * @var PasteTransformer
     */
    protected $pasteTransformer, $statusCode, $webhooks, $request;
    private $limit = 5;

    /**
     * @param PasteTransformer $pasteTransformer
     * @param ApiStatusCode $statusCode
     * @param Webhooks $webhooks
     */
    function __construct(PasteTransformer $pasteTransformer, ApiStatusCode $statusCode, Webhooks $webhooks, Request $request) {
        $this->middleware('auth.api', ['except' => ['show', 'index']]);
        $this->pasteTransformer = $pasteTransformer;
        $this->statusCode = $statusCode;
        $this->webhooks = $webhooks;
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() {
        $limit = $this->request->input('limit', $this->limit);
        $limit = $limit > $this->limit ? $this->limit : $limit;

        $pastes = Paste::wherePublic(true);

        if (Auth::check())
            $pastes->orWhere('creator', Auth::user()->id);

        $pastes = $pastes->paginate($limit);

        return $this->returnWithPagination($pastes, [
            'data' => $this->pasteTransformer->transformCollection($pastes->all())
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id) {
        $paste = Paste::find($id);

        if (!$paste)
            return $this->statusCode->respondNotFound("Paste does not exist!");
        else if (!$paste->public) {
            if (!(Auth::check() && $paste->creator == Auth::user()->id))
                return $this->statusCode->respondValidationFailed("You don't have permission to view this paste.");
        }

        return $this->statusCode->respond([
            'data' => $this->pasteTransformer->transform($paste)
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() {
        $title = $this->request->input('title');
        $content = $this->request->input('content');
        $force = $this->request->input('force');

        if (!$content)
            return $this->statusCode->respondWithError("A required field has been left blank.");
        else if (strlen($content) > env("PASTE_MAX_LEN", 500000) && !$force)
            return $this->statusCode->respondWithError("Paste exceeds " . env("PASTE_MAX_LEN", 500000) . " max character limit. Set the force param to true to cut your paste after " . env("PASTE_MAX_LEN", 500000) . "characters");

        $slug = SlugGenerator::generate();

        ShortUrl::create([
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $slug,
            'path' => $slug
        ]);

        file_put_contents(storage_path() . "/app/pastes/$slug.txt", $content);

        Paste::create([
            'slug' => $slug,
            'creator' => Auth::user()->id,
            'title' => $title,
            'public' => $this->request->input('public')
        ]);

        return $this->statusCode->respondCreated($slug);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id) {
        $paste = Paste::find($id);

        if ($paste->creator == Auth::user()->id) {
            ShortUrl::wherePath($paste->slug)->delete();
            $paste->delete();
            return $this->statusCode->respondWithSuccess("Paste has been deleted.");
        }

        return $this->statusCode->respondValidationFailed("You don't have permission to delete this paste.");
    }
}