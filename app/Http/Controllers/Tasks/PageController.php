<?php namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Tools\Misc\GitHub;
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
        if (Auth::check())\
            $tasks = Task::all();
        else
            $tasks = Task::wherePublic(true)->get();

        $users = User::all();
        $displaynames = [];

        foreach ($users as $user)
            $displaynames[$user->id] = $user->displayname;

        $gitIssues = array_sort(GitHub::getIssues(), function($value){
            return $value->created_at;
        });

        return view('tasks.index', [
            'tasks'        => $tasks,
            'users'        => $users,
            'displaynames' => $displaynames,
            'gitIssues'    => $gitIssues
        ]);
    }

}
