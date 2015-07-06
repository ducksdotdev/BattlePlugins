<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Misc\GitHub;
use App\Tools\Misc\Jenkins;
use App\Tools\Models\Alert;
use App\Tools\Models\Blog;
use App\Tools\Models\Task;
use App\Tools\Models\User;
use App\Tools\Queries\ServerSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
	protected $updateMins = 1;

	function __construct () {
		$this->middleware('auth', ['except' => ['index']]);

		if (auth()->check()) {
			view()->share('alerts', Alert::whereUser(auth()->user()->id)->latest()->get());
			view()->share('avatar', GitHub::getAvatar(auth()->user()->displayname));
		}

		view()->share('alert_bar', ServerSetting::get('alert_bar'));
	}

	public function index () {
		if (auth()->check()) {
			$displaynames = [];
			foreach (User::all() as $user)
				$displaynames[$user->id] = $user->displayname;

			$hits = ServerSetting::get('blogviews');

			$userId = auth()->user()->id;

			$hitChange = $hits - Cache::pull('hitChange_' . $userId);
			Cache::forget('hitChange_' . $userId);
			Cache::forever('hitChange_' . $userId, $hits);

			$dash_jenkins = ServerSetting::get('dash_jenkins');

			$tasks = Task::whereStatus(false);

			$myIssues = 0;
			$issues = 0;
			$closed = 0;

			foreach (GitHub::getIssues() as $issue) {
				if ($issue->assignee && $issue->assignee->login == auth()->user()->displayname && $issue->state == 'open')
					$myIssues++;

				if ($issue->state == 'open')
					$issues++;
				else
					$closed++;
			}

			$closed = $closed + count(Task::where('status', true)->get());
			$myTasks = count($tasks->where('assigned_to', $userId)->get()) + $myIssues;

			return view('admin.index', [
				'title' => 'Dashboard',
				'issues' => $issues,
				'blogs' => Blog::latest()->get(),
				'blogList' => Blog::latest()->limit(3)->get(),
				'tasks' => new Task,
				'queuedJobs' => count(DB::table('jobs')->get()),
				'failedJobs' => count(DB::table('failed_jobs')->get()),
				'displaynames' => $displaynames,
				'rssFeed' => $dash_jenkins ? Jenkins::getFeed('rssLatest', 3) : null,
				'jenkins' => $dash_jenkins,
				'hitChange' => $hitChange,
				'hits' => $hits,
				'updateMins' => $this->updateMins,
				'github' => GitHub::getEventsFeed(),
				'myTasks' => $myTasks,
				'closedTasks' => $closed
			]);
		} else
			return view('admin.login');
	}

	public function settings () {
		return view('admin.settings', [
			'title' => 'User Settings'
		]);
	}

	public function createUser () {
		return view('admin.createuser', [
			'title' => 'Create User'
		]);
	}

	public function modifyUser () {
		return view('admin.modifyuser', [
			'title' => 'Modify User',
			'users' => User::all()
		]);
	}

	public function alerts () {
		return view('admin.alerts', [
			'title' => 'Create Alert'
		]);
	}

	public function cms () {
		return view('admin.cms', [
			'title' => 'Manage Content',
			'jenkins' => ServerSetting::get('jenkins'),
			'dash_jenkins' => ServerSetting::get('dash_jenkins'),
			'registration' => ServerSetting::get('registration'),
			'footer' => ServerSetting::get('footer'),
			'alert_bar' => ServerSetting::get('alert_bar')
		]);
	}

	public function serverStats () {
		$serverData = Cache::get('serverData');

		return view('admin.partials.dashboard.serverstats', [
			'serverData' => $serverData,
			'updateMins' => $this->updateMins
		]);
	}

	public function github () {
		return view('admin.github', [
			'title' => 'GitHub Information',
			'github' => GitHub::getEventsFeed(100),
			'members' => GitHub::getOrgMembers(),
			'repos' => GitHub::getRepositories()
		]);
	}
}