<?php
/**
 * Created by IntelliJ IDEA.
 * User: Justin
 * Date: 5/29/2015
 * Time: 7:24 PM
 */

namespace App\Http\Controllers\API\Endpoints;

use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\UserTransformer;
use App\Tools\Models\User;
use Illuminate\Http\Request;

class UsersController extends ApiController {

	/**
	 * @var userTransformer
	 */
	protected $userTransformer, $statusCode;

	/**
	 * @param userTransformer $userTransformer
	 * @param ApiStatusCode $statusCode
	 */
	function __construct (UserTransformer $userTransformer, ApiStatusCode $statusCode) {
		$this->userTransformer = $userTransformer;
		$this->statusCode = $statusCode;
		$this->middleware('auth.api', ['on'=>'post']);
	}

	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(Request $request){
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
	public function show($id){
		$user = User::findOrFail($id);

		if(!$user)
			return $this->statusCode->respondNotFound("User does not exist!");

		return $this->statusCode->respond([
			'data' => $this->userTransformer->transform($user)
		]);
	}
}