<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\Alert;
use App\Tools\Models\Blog;
use App\Tools\Models\ServerSettings;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use App\Tools\URL\Domain;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
    function __construct() {
        $this->middleware('auth', ['except' => ['index']]);

        if (auth()->check())
            view()->share('alerts', Alert::whereUser(Auth::user()->id)->latest()->get());
    }

    public static function index() {
        if (Auth::check()) {
            $updateMins = 3;

            $serverData = Cache::remember('serverData', $updateMins, function () {
                $serverData = [];
                foreach (config('servers') as $name => $server) {
                    $serverData['servers'][] = [
                        'name' => $name,
                        'online' => Domain::isOnline($server)
                    ];
                }

                $serverData['updated_at'] = Carbon::now();

                return $serverData;
            });

            $displaynames = [];
            foreach (User::all() as $user)
                $displaynames[$user->id] = $user->displayname;

            return view('admin.index', [
                'title' => 'Dashboard',
                'tasks' => count(Task::whereStatus(false)->get()),
                'blogs' => Blog::latest()->get(),
                'blogList' => Blog::latest()->limit(3)->get(),
                'tasks' => new Task,
                'queuedJobs' => count(DB::table('jobs')->get()),
                'failedJobs' => count(DB::table('failed_jobs')->get()),
                'serverData' => $serverData,
                'updateMins' => $updateMins,
                'displaynames' => $displaynames,
                'rssFeed' => Jenkins::getFeed(),
                'jenkins' => ServerSettings::whereKey('dash_jenkins')->pluck('value')
            ]);
        } else
            return view('admin.login');
    }

    public static function settings() {
        return view('admin.settings', [
            'title' => 'User Settings'
        ]);
    }

    public static function createUser() {
        return view('admin.createuser', [
            'title' => 'Create User'
        ]);
    }

    public static function modifyUser() {
        return view('admin.modifyuser', [
            'title' => 'Modify User',
            'users' => User::all()
        ]);
    }

    public function alerts() {
        return view('admin.alerts', [
            'title' => 'Create Alert'
        ]);
    }

    public function cms() {
        return view('admin.cms', [
            'title' => 'Manage Content',
            'jenkins' => ServerSettings::whereKey('jenkins')->pluck('value'),
            'dash_jenkins' => ServerSettings::whereKey('dash_jenkins')->pluck('value'),
            'registration' => ServerSettings::whereKey('registration')->pluck('value'),
            'footer' => ServerSettings::whereKey('footer')->pluck('value')
        ]);
    }
}