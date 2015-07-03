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

        view()->share('alert_bar', ServerSettings::get('alert_bar');
    }

    public static function index() {
        if (Auth::check()) {
            $displaynames = [];
            foreach (User::all() as $user)
                $displaynames[$user->id] = $user->displayname;

            $hits = ServerSettings::get('blogviews');

            $hitChange = $hits - Cache::pull('hitChange');
            Cache::forget('hitChange');
            Cache::forever('hitChange', $hits);

            return view('admin.index', [
                'title' => 'Dashboard',
                'tasks' => count(Task::whereStatus(false)->get()),
                'blogs' => Blog::latest()->get(),
                'blogList' => Blog::latest()->limit(3)->get(),
                'tasks' => new Task,
                'queuedJobs' => count(DB::table('jobs')->get()),
                'failedJobs' => count(DB::table('failed_jobs')->get()),
                'displaynames' => $displaynames,
                'rssFeed' => Jenkins::getFeed(),
                'jenkins' => ServerSettings::get('dash_jenkins'),
                'hitChange' => $hitChange,
                'hits' => $hits
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
            'jenkins' => ServerSettings::get('jenkins'),
            'dash_jenkins' => ServerSettings::get('dash_jenkins'),
            'registration' => ServerSettings::get('registration'),
            'footer' => ServerSettings::get('footer'),
            'alert_bar' => ServerSettings::get('alert_bar')
        ]);
    }

    public function serverStats() {
        $updateMins = 3;

        $serverData = Cache::remember('serverData', $updateMins, function () {
            $serverData = [];
            foreach (config('servers') as $name => $server) {
                $serverData['servers'][] = [
                    'name' => $name,
                    'online' => Domain::isOnline($server),
                    'url' => $server
                ];
            }

            $serverData['updated_at'] = Carbon::now();

            return $serverData;
        });

        return view('admin.partials.dashboard.serverstats', [
            'serverData' => $serverData,
            'updateMins' => $updateMins,
        ]);
    }
}