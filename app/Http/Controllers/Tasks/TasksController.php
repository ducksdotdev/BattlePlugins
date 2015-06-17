<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use App\Tools\VerifyHMAC;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    private $webhooks;

    public function __construct(Webhooks $webhooks)
    {
        $this->webhooks = $webhooks;
    }

    public function createTask(Request $request)
    {
        $title = $request->input('title');
        $public = $request->input('public');

        if (!$title)
            $title = 'Untitled';

        if (!$public)
            $public = false;

        Task::create([
            'title' => $title,
            'creator' => Auth::user()->id,
            'assigned_to' => $request->input('assigned_to'),
            'public' => $public,
            'content' => $request->input('content')
        ]);

        return redirect('/');
    }

    public function deleteTask($id)
    {
        Task::find($id)->delete();
    }

    public function gitHubCreate(Request $request)
    {
        $payload = file_get_contents('php://input');
        if (VerifyHMAC::validateSignature($request->header('X-Hub-Signature'), $payload)) {
            Auth::loginUsingId(24);

            $action = $request->json('action');

            $title = '[Issue ' . $request->json('issue.id') . '] ' . $request->json('issue.title');
            $id = Task::whereTitle($title)->pluck('id');

            if ($action == 'opened') {
                Task::create([
                    'title' => $title,
                    'creator' => 24,
                    'assigned_to' => 0,
                    'public' => true,
                    'content' => $request->json('issue.html_url')
                ]);
            } else if ($action == 'closed') {
                $this->completeTask($id);
            } else if ($action == 'assigned') {
                $assigneeName = $request->json('assignee.login');
                $assignee = User::whereDisplayname($assigneeName)->first();
                if ($assignee) {
                    Task::find($id)->update(['assigned_to' => $assignee->id]);
                }
            } else if ($action == 'unassigned') {
                Task::find($id)->update(['assigned_to' => 0]);
            }
        } else
            return redirect('/');
    }

    public function completeTask($id)
    {
        Task::find($id)->update(['status' => 1]);
    }
}