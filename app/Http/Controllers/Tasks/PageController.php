<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use Auth;

class PageController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::check())
            $tasks = Task::where('status', '!=', 2)->get();
        else
            $tasks = Task::wherePublic(true)->where('status', '!=', 2)->get();

        $users = User::where('id', '!=', 24)->get();

        return view('tasks.index', ['tasks' => $tasks, 'users' => $users]);
    }

}
