<?php

use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\DateUtil;
use BattleTools\Util\Deploy;
use Carbon\Carbon;
use Symfony\Component\Process\Process;

class AdminController extends BaseController{

	public function __construct(){
		parent::setActive("Administration");
		$this->beforeFilter('auth.administrator');
	}

	public function getBlog(){
		$vars['title'] = 'Blog Administration';

		return View::make('admin.blog', $vars);
	}

	public function saveBlog(){
		$title = Input::get('title');
		$content = Input::get('content');

		$input = array(
			'title'   => $title,
			'content' => $content
		);

		$rules = array(
			'title'   => 'required|max:132',
			'content' => 'required'
		);

		$messages = array(
			'title.required'   => "Title is blank",
			'title.max'        => "Title is too long",
			'content.required' => "Content is blank"
		);

		$validator = Validator::make($input, $rules, $messages);
		if($validator->fails()){
			$reason = "<p>We couldn't create your blog post! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result" => "failure", "reason" => $reason));
		}

		$content = str_replace('<a ', '<a target="_blank" ', $content);
		$id = DB::table('blog')->insertGetId(array(
			'title'      => $title,
			'author'     => Auth::user()->id,
			'content'    => $content,
			'created_at' => Carbon::now()
		));

		return Response::json(array('result' => 'success', 'reason' => '/blog/'.$id));

	}

	public function editBlog(){
		$title = Input::get('title');
		$content = Input::get('content');

		$input = array(
			'title'   => $title,
			'content' => $content
		);

		$rules = array(
			'title'   => 'required|max:132',
			'content' => 'required'
		);

		$messages = array(
			'title.required'   => "Title is blank",
			'title.max'        => "Title is too long",
			'content.required' => "Content is blank"
		);

		$validator = Validator::make($input, $rules, $messages);
		if($validator->fails()){
			$reason = "<p>We couldn't create your blog post! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result" => "failure", "reason" => $reason));
		}

		$id = Input::get('id');
		$content = str_replace('<a ', '<a target="_blank" ', $content);
		DB::table('blog')->where('id', $id)->update(array(
			'title'   => $title,
			'content' => $content,
		));

		return Response::json(array('result' => 'success'));
	}

	public function deleteBlog(){
		$id = Input::get('id');

		return DB::table('blog')->where('id', $id)->delete();
	}

	public function manageUsers(){
		$vars['title'] = 'Manage Users';

		return View::make('admin.manageUsers', $vars);
	}

	public function getUserGroupsForm(){
		$username = Input::get('username');
		$uid = UserSettings::getIdFromUsername($username);
		if(count($uid) == 0){
			return Response::json(array("result" => "failure"));
		}

		$vars['has'] = UserGroups::getGroups($uid);
		$vars['groups'] = UserGroups::getAll();

		foreach($vars['groups'] as $group){
			$groupNames[$group] = UserGroups::getGroupName($group);
		}

		$vars['groupNames'] = $groupNames;

		return View::make('ajax.userGroupsForm', $vars);
	}

	public function changeUserGroups(){
		$username = Input::get('username');
		$id = UserSettings::getIdFromUsername($username);
		if(count($id) == 0){
			return Response::json(array("result" => "failure", 'reason' => 'That user doesn\'t exist!'));
		}

		$currentGroups = UserGroups::getGroups($id);
		foreach(UserGroups::getAll() as $group){
			$str = "group-".$group;
			if(Input::has($str)){
				if(!in_array($group, $currentGroups)){
					UserGroups::addGroup($id, $group);
				}
			}else{
				if(in_array($group, $currentGroups)){
					UserGroups::removeGroup($id, $group);
				}
			}
		}

		return Response::json(array('result' => 'success'));
	}

	public function getSetting(){
		$username = Input::get('username');
		$setting = Input::get('setting');

		$input = array(
			'username' => $username,
			'setting'  => $setting
		);

		$rules = array(
			'username' => 'required|max:16',
			'setting'  => 'required'
		);

		$messages = array(
			'username.required' => "Username field is blank",
			'username.max'      => "Username is too long",
			'setting.required'  => "Setting field is blank"
		);

		$validator = Validator::make($input, $rules, $messages);
		if($validator->fails()){
			$reason = "<p>We couldn't modify that setting! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result" => "failure", "reason" => $reason));
		}

		$uid = UserSettings::getIdFromUsername($username);
		if(count($uid) == 0){
			return Response::json(array("result" => "failure", "reason" => "A user with that name doesn't exist."));
		}

		return Response::json(array('result' => 'success', 'setting' => UserSettings::get($uid, $setting)));
	}

	public function setSetting(){
		$username = Input::get('username');
		$setting = Input::get('setting');

		$input = array(
			'username' => $username,
			'setting'  => $setting
		);

		$rules = array(
			'username' => 'required|max:16',
			'setting'  => 'required'
		);

		$messages = array(
			'username.required' => "Username field is blank",
			'username.max'      => "Username is too long",
			'setting.required'  => "Setting field is blank"
		);

		$validator = Validator::make($input, $rules, $messages);
		if($validator->fails()){
			$reason = "<p>We couldn't modify that setting! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result" => "failure", "reason" => $reason));
		}

		$uid = UserSettings::getIdFromUsername($username);
		if(count($uid) == 0){
			return Response::json(array("result" => "failure", "reason" => "A user with that name doesn't exist."));
		}

		$value = Input::get('value');
		if(empty($value)){
			UserSettings::delete($uid, $setting);
		}else{
			UserSettings::set($uid, $setting, $value);
		}

		return Response::json(array('result' => 'success'));
	}

	public function getStatistics(){
		$vars['title'] = 'Statistics';
		$vars['apiRequests'] = DB::table('api_requests')->
			select('*', DB::raw('count(*) as total'))->
			groupBy('route', 'ip')->
			orderBy('total', 'desc')->
			get();

		$vars['statisticRequests'] = DB::table('statistic_requests')->
			select('*', DB::raw('count(*) as total'))->
			groupBy('server')->
			orderBy('total', 'desc')->
			take(10)->get();

		$usernames = array();

		foreach($vars['apiRequests'] as $request){
			$usernames[$request->user_id] = UserSettings::getUsernameFromId($request->user_id);
		}

		$vars['statisticsCache'] = Cache::get('statistics');

		$vars['usernames'] = $usernames;
		$vars['now'] = Carbon::now();
		$vars['diff'] = DateUtil::getTimeToNextThirty(false);
		$lastUpdate = Cache::get('lastUpdate', 'never');

		if($lastUpdate != 'never'){
			$lastUpdate = $lastUpdate->diffForhumans();
		}

		$vars['lastUpdate'] = $lastUpdate;

		return View::make('admin.statistics', $vars);
	}

	public function clearAPIRequests(){
		DB::table('api_requests')->delete();

		return Redirect::to('/administrator/statistics');
	}

	public function clearStatisticRequests(){
		$plugins = DB::table('plugin_statistics')->get();
		$servers = DB::table('server_statistics')->get();
		if(count($servers) == 0 && count($plugins) == 0){
			DB::table('statistic_requests')->delete();
		}

		return Redirect::to('/administrator/statistics');
	}

	public function forceStatisticsUpdate(){

		$branch = Deploy::isDeveloperMode() ? 'dev' : 'master';

		$cd = Config::get('deploy.path-to-branch');
		$cd = str_replace('{branch}', $branch, $cd);

		$process = new Process('php laravel/artisan battle:savestats', $cd);
		$process->start();
		while($process->isRunning()){
		}

		Cache::put('lastUpdate', Carbon::now(), DateUtil::getTimeToNextThirty());

		return Redirect::to('/administrator/statistics');

	}
}
