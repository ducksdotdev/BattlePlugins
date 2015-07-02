<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\Alert;
use App\Tools\Models\Blog;
use App\Tools\Models\ServerSettings;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
    function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public static function index() {
        if (Auth::check()) {
            return view('admin.index', [
                'title' => 'Dashboard',
                'alerts' => Alert::whereUser(Auth::user()->id)->latest()->get(),
                'tasks' => count(Task::whereStatus(false)->get()),
                'blog' => Blog::latest()->first(),
                'queuedJobs' => count(DB::table('jobs')->get()),
                'failedJobs' => count(DB::table('failed_jobs')->get())
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
            'registration' => ServerSettings::whereKey('registration')->pluck('value'),
            'footer' => ServerSettings::whereKey('footer')->pluck('value')
        ]);
    }
}