<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Blog;
use App\Tools\StatusCodes\ApiStatusCode;
use App\Tools\Transformers\BlogTransformer;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class BlogsController extends ApiController
{
    /**
     * @var BlogTransformer
     */
    protected $blogTransformer, $statusCode, $webhooks, $request;
    private $limit = 5;

    /**
     * @param BlogTransformer $blogTransformer
     * @param ApiStatusCode $statusCode
     * @param Webhooks $webhooks
     */
    function __construct (BlogTransformer $blogTransformer, ApiStatusCode $statusCode, Webhooks $webhooks, Request $request) {
        $this->middleware('auth.api', ['except'=>['show', 'index']]);
        $this->blogTransformer = $blogTransformer;
        $this->statusCode = $statusCode;
        $this->webhooks = $webhooks;
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(){
        $limit = $this->request->input('limit', $this->limit);
        $limit = $limit > $this->limit ? $this->limit : $limit;

        $blogs = Blog::paginate($limit);
        return $this->returnWithPagination($blogs, [
            'data' => $this->blogTransformer->transformCollection($blogs->all())
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id){
        $blog = Blog::find($id);

        if(!$blog)
            return $this->statusCode->respondNotFound("Blog does not exist!");

        return $this->statusCode->respond([
            'data' => $this->blogTransformer->transform($blog)
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() {
        $title = $this->request->input('title');
        $content = $this->request->input('content');

        if(!$title || !$content)
            return $this->statusCode->respondWithError("A required field has been left blank.");

        $insert = [
            'title' => $title,
            'author' => Auth::user()->id,
            'content' =>  $content,
        ];

        $blog = new Blog;
        $blog->create($insert);

        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_CREATED);

        return $this->statusCode->respondCreated('Blog successfully created.');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id){
        $blog = Blog::find($id);
        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_DELETED);
        $blog->delete();

        return $this->statusCode->respondWithSuccess("Blog has been deleted.");
    }

    public function update($id){
        $blog = Blog::find($id);

        if(!$blog)
            return $this->statusCode->respondNotFound("Blog does not exist!");

        $blog->update($this->request->all());

        $this->webhooks->sendPayload($this->blogTransformer->transform($blog), Webhooks::BLOG_MODIFIED);

        return $this->statusCode->respondWithSuccess("Blog has been modified.");
    }
}