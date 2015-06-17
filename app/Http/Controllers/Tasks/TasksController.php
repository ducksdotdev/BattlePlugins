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

    private $webhooks, $request;

    public function __construct(Request $request, Webhooks $webhooks)
    {
        $this->request = $request;
        $this->webhooks = $webhooks;
    }

    public function createTask()
    {
        $title = $this->request->input('title');
        $public = $this->request->input('public');

        if (!$title)
            $title = 'Untitled';

        if (!$public)
            $public = false;

        Task::create([
            'title' => $title,
            'creator' => Auth::user()->id,
            'assigned_to' => $this->request->input('assigned_to'),
            'public' => $public,
            'content' => $this->request->input('content')
        ]);

        return redirect('/');
    }

    public function deleteTask($id)
    {
        Task::find($id)->delete();
    }

    public function gitHubCreate()
    {
        $payload = file_get_contents('php://input');
        if (VerifyHMAC::validateSignature($this->request->header('X-Hub-Signature'), $payload)) {
            Auth::loginUsingId(24);

            $action = $this->request->json('action');

            $title = '[Issue ' . $this->request->json('issue.id') . '] ' . $this->request->json('issue.title');
            $id = Task::whereTitle($title)->pluck('id');

            if ($action == 'opened') {
                Task::create([
                    'title' => $title,
                    'creator' => 24,
                    'assigned_to' => 0,
                    'public' => true,
                    'content' => $this->request->json('issue.html_url')
                ]);
            } else if ($action == 'closed') {
                $this->completeTask($id);
            } else if ($action == 'assigned') {
                $assigneeName = $this->request->json('assignee.login');
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