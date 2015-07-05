<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Tools\Models\Task;
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

        Task::create([
            'title'       => $title,
            'creator'     => Auth::user()->id,
            'assigned_to' => $request->input('assigned_to'),
            'public'      => $public,
            'content'     => $request->input('content')
        ]);

        return redirect('/');
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