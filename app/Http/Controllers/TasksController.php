<?php namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Tools\Misc\GitHub;
use App\Tools\Misc\UserSettings;
use Auth;

/**
 * Class TasksController
 * @package App\Http\Controllers\Tasks
 */
class TasksController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => 'getIndex']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateTask(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_TASK)) {
            $title = $request->input('title');
            $public = $request->input('public');

            if (!$title)
                $title = 'Untitled';

            if (!$public)
                $public = false;

            $task = new Task();

            $assignee = $request->input('assignee_id');
            if ($assignee)
                $task->assignee_id = $assignee;

            $task->title = $title;
            $task->user_id = Auth::user()->id;
            $task->public = $public;
            $task->content = $request->input('content');
            $task->save();

            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteTask($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_TASK)) {
            Task::find($id)->delete();
            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCompleteTask($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_TASK)) {
            Task::find($id)->update([
                'completed' => true
            ]);

            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshIssues() {
        if (Auth::check())
            Cache::forget('gitIssues');

        return redirect()->back();
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex() {
        if (Auth::check() && UserSettings::hasNode(auth()->user(), UserSettings::VIEW_TASK))
            $tasks = Task::all();
        else
            $tasks = Task::wherePublic(true)->get();

        $users = User::all();

        $gitIssues = array_sort(GitHub::getIssues(), function ($value) {
            return $value->created_at;
        });

        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users,
            'gitIssues' => $gitIssues
        ]);
    }

}
