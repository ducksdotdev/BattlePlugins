<?php

namespace App\Http\Controllers\API\Endpoints;

use App\Tools\API\StatusCodes\ApiStatusCode;
use App\Tools\API\Transformers\TaskTransformer;
use App\Tools\Models\Task;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

/**
 * Class TasksController
 * @package App\Http\Controllers
 */
class TasksController extends ApiController {

	/**
	 * @var TaskTransformer
	 */
	protected $taskTransformer, $statusCode, $webhooks, $request;

	/**
	 * @param TaskTransformer $taskTransformer
	 * @param ApiStatusCode $statusCode
	 * @param Webhooks $webhooks
	 */
    function __construct(TaskTransformer $taskTransformer, ApiStatusCode $statusCode, Webhooks $webhooks, Request $request)
    {
		$this->middleware('auth.api');
		$this->taskTransformer = $taskTransformer;
		$this->statusCode = $statusCode;
		$this->webhooks = $webhooks;
		$this->request = $request;
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(){
		$limit = $this->request->input('limit', 20);
		$limit = $limit > 20 ? 20 : $limit;

		$tasks = Task::latest()->paginate($limit);
		return $this->returnWithPagination($tasks, [
			'data' => $this->taskTransformer->transformCollection($tasks->all())
		]);
	}

	/**
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function show($id){
		$task = Task::find($id);

		if(!$task)
			return $this->statusCode->respondNotFound("Task does not exist!");

		return $this->statusCode->respond([
			'data' => $this->taskTransformer->transform($task)
		]);
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function store() {
		$insert = [
			'title' => $this->request->input('title') ?: 'Untitled',
			'creator' => Auth::user()->id,
			'assigned_to' =>  $this->request->input('assigned_to') ?: 0,
			'public' => $this->request->input('public') ?: false,
			'content' => $this->request->input('content') ?: ''
		];

        Task::create($insert);

		return $this->statusCode->respondCreated('Task successfully created.');
	}

	/**
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function destroy($id){
		Task::find($id)->delete();
		return $this->statusCode->respondWithSuccess("Task has been deleted.");
	}

	public function update($id){
		$task = Task::find($id);

		if(!$task)
			return $this->statusCode->respondNotFound("Task does not exist!");

		$task->update($this->request->all());

		return $this->statusCode->respondWithSuccess("Task has been modified.");
	}

}