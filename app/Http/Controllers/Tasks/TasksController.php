<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TasksController extends Controller {

    private $webhooks;

    public function __construct(Webhooks $webhooks) {
        $this->middleware('auth');
        $this->webhooks = $webhooks;
    }

    public function createTask(Request $request) {
        $title = $request->input('title');
        $public = $request->input('public');

        if (!$title)
            $title = 'Untitled';

        if (!$public)
            $public = false;

        $assignee = $request->input('assignee_id');

        $task = new Task();
        $task->title = $title;
        $task->user_id = Auth::user()->id;
        $task->assignee_id = $assignee;
        $task->public = $public;
        $task->content = $request->input('content');
        $task->save();

        return redirect()->back();
    }

    public function deleteTask($id) {
        Task::find($id)->delete();
        return redirect()->back();
    }

    public function completeTask($id) {
        Task::find($id)->update(['status' => 1]);
        return redirect()->back();
    }

    public function refreshIssues() {
        if (Auth::check())
            Cache::forget('gitIssues');

        return redirect()->back();
    }
}