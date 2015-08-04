<?php

namespace App\Http\Controllers\Endpoints;

use App\API\StatusCodes\ApiStatusCode;
use App\API\Transformers\TaskTransformer;
use App\Models\Task;
use App\Tools\Misc\UserSettings;
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
    function __construct(TaskTransformer $taskTransformer, ApiStatusCode $statusCode, Webhooks $webhooks, Request $request) {
        $this->middleware('auth.api');
        $this->taskTransformer = $taskTransformer;
        $this->statusCode = $statusCode;
        $this->webhooks = $webhooks;
        $this->request = $request;

        if (!UserSettings::hasNode(auth()->user(), UserSettings::VIEW_TASKS))
            return $this->statusCode->respondValidationFailed();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() {
        $limit = $this->request->input('limit', 20);
        $limit = $limit > 20 ? 20 : $limit;

        $tasks = Task::orderBy('id', 'desc')->paginate($limit);
        return $this->returnWithPagination($tasks, [
            'data' => $this->taskTransformer->transformCollection($tasks->all())
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id) {
        $task = Task::find($id);

        if (!$task)
            return $this->statusCode->respondNotFound("Task does not exist!");

        return $this->statusCode->respond([
            'data' => $this->taskTransformer->transform($task)
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_TASK)) {
            $insert = [
                'title' => $this->request->input('title') ?: 'Untitled',
                'user_id' => Auth::user()->id,
                'assignee_id' => $this->request->input('assignee_id') ?: 0,
                'public' => $this->request->input('public') ?: false,
                'content' => $this->request->input('content') ?: ''
            ];

            Task::create($insert);

            return $this->statusCode->respondCreated('Task successfully created.');
        } else
            return $this->statusCode->respondValidationFailed();
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_TASK)) {
            Task::find($id)->delete();
            return $this->statusCode->respondWithSuccess("Task has been deleted.");
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_TASK)) {
            $task = Task::find($id);

            if (!$task)
                return $this->statusCode->respondNotFound("Task does not exist!");

            $task->update($this->request->all());

            return $this->statusCode->respondWithSuccess("Task has been modified.");
        } else
            return $this->statusCode->respondValidationFailed();
    }

}