<?php

namespace App\Http\Controllers\Endpoints;

use App\Models\User;
use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\UserTransformer;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers\Endpoints
 */
class UsersController extends ApiController {

    /**
     * @var userTransformer
     */
    protected $userTransformer, $statusCode;

    /**
     * @param userTransformer $userTransformer
     * @param ApiStatusCode $statusCode
     */
    function __construct(UserTransformer $userTransformer, ApiStatusCode $statusCode) {
        $this->userTransformer = $userTransformer;
        $this->statusCode = $statusCode;
        $this->middleware('auth.api', ['on' => 'post']);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request) {
        $limit = $request->input('limit', 20);
        $limit = $limit > 20 ? 20 : $limit;

        $users = User::paginate($limit);
        return $this->returnWithPagination($users, [
            'data' => $this->userTransformer->transformCollection($users->all())
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id) {
        $user = User::find($id);

        if (!$user)
            return $this->statusCode->respondNotFound("User does not exist!");

        return $this->statusCode->respond([
            'data' => $this->userTransformer->transform($user)
        ]);
    }
}