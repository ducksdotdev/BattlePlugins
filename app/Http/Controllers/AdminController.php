<?php
namespace App\Http\Controllers;

use App\Jenkins\Jenkins;
use App\Models\Alert;
use App\Models\Blog;
use App\Models\Paste;
use App\Models\Permission;
use App\Models\Task;
use App\Models\User;
use App\Repositories\AlertRepository;
use App\Repositories\BlogRepository;
use App\Tools\Domain;
use App\Tools\GitHub;
use App\Tools\LaravelLogViewer;
use App\Tools\Settings;
use App\Tools\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller {
    /**
     * @var int
     */
    protected $updateMins = 1;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    function __construct(Request $request) {
        $this->middleware('auth.admin');

        if (auth()->check()) {
            view()->share('alerts', auth()->user()->alerts);
            view()->share('alert_bar', Settings::get('alert_bar'));
        }

        $this->request = $request;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        return view('admin.index', [
            'title'       => 'Dashboard',
            'issues'      => count(GitHub::getIssues()),
            'blogs'       => count(Blog::all()),
            'tasks'       => new Task,
            'jenkins'     => Jenkins::getAllBuilds(3),
            'updateMins'  => $this->updateMins,
            'github'      => GitHub::getEventsFeed(),
            'myTasks'     => count(auth()->user()->tasks()->get()),
            'closedTasks' => count(Task::all()),
            'pastes'      => count(Paste::all()),
            'downloads'   => Jenkins::getBuildDownloadCount(),
            'jenkins_online' => Domain::remoteFileExists('http://ci.battleplugins.com'),
            'log'         => LaravelLogViewer::getPaginated(null, 1, 1)[0],
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getSettings() {
        return view('admin.settings', [
            'title' => 'User Settings'
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getCreateUser() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_USER)) {
            return view('admin.createuser', [
                'title' => 'Create User'
            ]);
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getModifyUser() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_USER)) {
            return view('admin.modifyuser', [
                'title' => 'Modify User',
                'users' => User::all()
            ]);
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getModifyUserPermissions($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_USER)) {
            $user = User::find($id);

            return view('admin.modifyuserpermissions', [
                'title' => 'Modify ' . $user->displayname,
                'user' => $user,
                'nodes' => UserSettings::getPossible()
            ]);
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getAlerts() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_ALERT)) {
            return view('admin.alerts', [
                'title' => 'Create Alert',
                'adminalerts' => Alert::all()
            ]);
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getCms() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MANAGE_CONTENT)) {
            return view('admin.cms', [
                'title'     => 'Manage Content',
                'jenkins'   => Settings::get('jenkins'),
                'registration' => Settings::get('registration'),
                'alert_bar' => Settings::get('alert_bar'),
                'comment_feed' => Settings::get('comment_feed')
            ]);
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getServerStats() {
        return view('admin.dashboard.serverstats', [
            'serverData' => Cache::get('serverData'),
            'updateMins' => $this->updateMins
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getGithub() {
        return view('admin.github', [
            'title'  => 'GitHub Information',
            'github' => GitHub::getEventsFeed(25),
            'members' => GitHub::getOrgMembers(),
            'repos'  => GitHub::getRepositories()
        ]);
    }

    /**
     * @param null $l
     * @param int $curPage
     * @param int $perPage
     * @return \Illuminate\View\View
     */
    public function getLogs($l = null, $curPage = 1, $perPage = 15) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DEVELOPER)) {

            $log_level = null;
            if ($this->request->has('log_level'))
                $log_level = $this->request->get('log_level');

            return view('admin.logs', [
                'title'     => 'Logs',
                'logs'      => LaravelLogViewer::getPaginated($l, $curPage, $perPage, $log_level),
                'files'     => LaravelLogViewer::getFiles(true),
                'current_file' => LaravelLogViewer::getFileName(),
                'perPage'   => $perPage,
                'url'       => $this->request->url(),
                'levels'    => LaravelLogViewer::getLogLevelsClasses(),
                'cur_level' => $log_level
            ]);
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getApiKeys() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::VIEW_API_KEYS)) {
            return view('admin.apikeys', [
                'title' => 'API Keys',
                'nodes' => Permission::whereNode(UserSettings::USE_API)->get()
            ]);
        } else abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getPermissionOverview() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::VIEW_PERMISSIONS)) {
            return view('admin.permissionoverview', [
                'title' => "Permission Overview",
                'nodes' => UserSettings::getPossible(),
                'permissions' => new Permission()
            ]);
        } else abort(403);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getPastes() {
        $pastes = new Paste();

        $type = $this->request->has('strict') ? 'where' : 'orWhere';

        if ($this->request->has('serverid')) {
            $serverid = $this->request->input('serverid');
            $serverid = starts_with($serverid, '#sid') ? $serverid : '#sid' . $serverid;

            $pastes = $pastes->$type('title', 'LIKE', '%' . $serverid . '%');
        }

        if ($this->request->has('slug'))
            $pastes = $pastes->$type('slug', 'LIKE', '%' . $this->request->input('slug') . '%');

        if ($this->request->has('author')) {
            $user = User::whereDisplayname($this->request->input('author'))->first();

            if ($user)
                $pastes = $pastes->$type('user_id', $user->id);
            elseif ($type == 'where')
                $pastes = [];
        }

        if ($pastes)
            $pastes = $pastes->get();

        return view('admin.pastes', [
            'title' => 'Pastes',
            'pastes' => $pastes,
            'inputs' => $this->request
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeletePaste($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_PASTES_AS_ADMIN)) {
            $paste = Paste::find($id);
            if ($paste)
                $paste->delete();

            return redirect()->back();
        } else abort(403);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAlert() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_ALERT)) {
            AlertRepository::create($this->request->get('content'), User::all());

            return redirect()->back()->with('success', 'Users have been alerted.');
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteAlert($id) {
        $alert = Alert::find($id);
        AlertRepository::detach($alert, auth()->user());
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminDeleteAlert($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_ALERT)) {
            $alert = Alert::find($id);
            AlertRepository::delete($alert);
            return redirect()->back();
        } else abort(403);
    }

    /**
     * @param $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postToggleSetting($setting) {
        Settings::toggle($setting);
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsonAlerts() {
        $alerts = auth()->user()->alerts;
        return response()->json($alerts);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getTasks() {
        if (auth()->check() && UserSettings::hasNode(auth()->user(), UserSettings::VIEW_TASK)) {
            $tasks = Task::all();
            $users = Permission::whereNode(UserSettings::VIEW_TASK);

            $ids = [];
            foreach ($users as $user)
                $id[] = $user->id;

            $users = User::whereIn('id', $ids)->get();

            return view('admin.viewtasks', [
                'tasks' => $tasks,
                'users' => $users,
                'title' => 'View Tasks'
            ]);
        } else abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteTask($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_TASK)) {
            Task::find($id)->delete();
            return redirect()->back();
        } else
            abort(403);
    }

    public function getGithubIssues($repo) {
        $users = User::all();
        $gitIssues = array_sort(GitHub::getIssues($repo), function ($value) {
            return $value->created_at;
        });

        return view('admin.githubissues', [
            'users' => $users,
            'gitIssues' => $gitIssues,
            'title' => $repo . ' Github Issues'
        ]);
    }

    public function getCreateTask() {
        return view('admin.createtask', [
            'title' => 'Create Task',
            'users' => User::all()
        ]);
    }

    public function postCreateTask(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_TASK)) {
            $title = $request->input('title');

            if (!$title)
                $title = 'Untitled';

            $task = new Task();

            $assignee = $request->input('assignee_id');
            if ($assignee)
                $task->assignee_id = $assignee;

            $task->title = $title;
            $task->user_id = Auth::user()->id;
            $task->content = $request->input('content');
            $task->save();

            return redirect()->back();
        } else
            abort(403);
    }

    public function getCreateBlogPost() {
        return view('admin.createblogpost', [
            'title' => 'Create Blog Post'
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateBlogPost() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_BLOG)) {
            $validator = $this->validate($this->request, [
                'title'   => 'required|max:64',
                'content' => 'required'
            ]);

            if ($validator && $validator->failed())
                return static::redirectBackWithErrors($validator->messages());

            BlogRepository::create($this->request->input('title'), $this->request->input('content'), auth()->user());
            return redirect()->action('BlogController@getIndex');
        } else
            abort(403);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditBlogPosts() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::BLOG_ADMIN))
            $posts = Blog::all();
        else
            $posts = Blog::whereAuthor(auth()->user()->id)->get();

        return view('admin.editblogposts', [
            'title' => 'Blog Posts',
            'posts' => $posts
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteBlogPost($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::DELETE_BLOG)) {
            BlogRepository::delete($id);
            return redirect()->back();
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditBlogPost($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_BLOG)) {
            if (UserSettings::hasNode(auth()->user(), UserSettings::BLOG_ADMIN))
                $post = Blog::find($id);
            else
                $post = Blog::whereAuthor(auth()->user()->id)->whereId($id)->first();

            if (!$post)
                abort(404);

            return view('admin.editblogpost', [
                'title' => 'Edit Post #' . $id,
                'post'  => $post
            ]);
        } else
            abort(403);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditBlogPost($id) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_BLOG)) {
            $title = $this->request->input('title');
            $content = $this->request->input('content');
            $blog = Blog::find($id);

            if (!$blog)
                return static::redirectBackWithErrors(['Invalid blog post']);

            $validator = $this->validate($this->request, [
                'title'   => 'required|max:64',
                'content' => 'required'
            ]);

            if ($validator && $validator->failed())
                return static::redirectBackWithErrors($validator->messages());

            BlogRepository::update($blog, [
                'title'   => $title,
                'content' => $content,
            ]);

            return static::redirectBackWithSuccess('Your blog post has been edited.');
        } else
            abort(403);
    }
}