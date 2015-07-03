<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\Alert;
use App\Tools\Models\Blog;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use App\Tools\Queries\ServerSetting;
use App\Tools\URL\Domain;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
    protected $updateMins = 1;

    function __construct() {
        $this->middleware('auth', ['except' => ['index']]);

        if (auth()->check())
            view()->share('alerts', Alert::whereUser(Auth::user()->id)->latest()->get());

        view()->share('alert_bar', ServerSetting::get('alert_bar'));
    }

    public function index() {
        if (Auth::check()) {
            $displaynames = [];
            foreach (User::all() as $user)
                $displaynames[$user->id] = $user->displayname;

            $hits = ServerSetting::get('blogviews');

            $hitChange = $hits - Cache::pull('hitChange');
            Cache::forget('hitChange');
            Cache::forever('hitChange', $hits);

            return view('admin.index', [
                'title'        => 'Dashboard',
                'tasks'        => count(Task::whereStatus(false)->get()),
                'blogs'        => Blog::latest()->get(),
                'blogList'     => Blog::latest()->limit(3)->get(),
                'tasks'        => new Task,
                'queuedJobs'   => count(DB::table('jobs')->get()),
                'failedJobs'   => count(DB::table('failed_jobs')->get()),
                'displaynames' => $displaynames,
                'rssFeed'      => Jenkins::getFeed(),
                'jenkins'      => ServerSetting::get('dash_jenkins'),
                'hitChange'    => $hitChange,
                'hits'         => $hits,
                'updateMins'   => $this->updateMins
            ]);
        } else
            return view('admin.login');
    }

    public function settings() {
        return view('admin.settings', [
            'title' => 'User Settings'
        ]);
    }

    public function createUser() {
        return view('admin.createuser', [
            'title' => 'Create User'
        ]);
    }

    public function modifyUser() {
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
            'title'        => 'Manage Content',
            'jenkins'      => ServerSetting::get('jenkins'),
            'dash_jenkins' => ServerSetting::get('dash_jenkins'),
            'registration' => ServerSetting::get('registration'),
            'footer'       => ServerSetting::get('footer'),
            'alert_bar'    => ServerSetting::get('alert_bar')
        ]);
    }

    public function serverStats() {
        $serverData = Cache::remember('serverData', $this->updateMins, function () {
            $serverData = [];
            foreach (config('servers') as $name => $server) {
                $serverData['servers'][] = [
                    'name'   => $name,
                    'online' => Domain::isOnline($server),
                    'url'    => $server
                ];
            }

            $serverData['updated_at'] = Carbon::now();

            return $serverData;
        });

        return view('admin.partials.dashboard.serverstats', [
            'serverData' => $serverData,
            'updateMins' => $this->updateMins,
        ]);
    }
}