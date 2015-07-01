<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use Auth;

class PageController extends Controller {

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index() {
        if (Auth::check())
            $tasks = Task::all();
        else
            $tasks = Task::wherePublic(true)->get();

        $users = User::all();
        $displaynames = [];

        foreach ($users as $user)
            $displaynames[$user->id] = $user->displayname;

        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users,
            'displaynames' => $displaynames
        ]);
    }

}
