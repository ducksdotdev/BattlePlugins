<?php

use BattleTools\API\ProjectInfo;
use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\Deploy;
use BattleTools\Util\Jenkins;

class PluginController extends BaseController{

	public function getPlugins(){
		$vars['title'] = "Our Plugins";

		$vars['plugins'] = DB::table("plugins")->get();

		$authors = array();
		foreach($vars['plugins'] as $plugin){
			$authors[$plugin->author] = UserSettings::getUsernameFromId($plugin->author);
		}

		$vars['authors'] = $authors;

		foreach($vars['plugins'] as $plugin){
			$ci = Jenkins::getLatestBuild("http://ci.battleplugins.com", $plugin->name);
			$builds[] = array('ci' => $ci, 'name' => $plugin->name, 'author' => $plugin->author, 'bukkit' => $plugin->bukkit);
		}

		arsort($builds);

		$vars['builds'] = $builds;

		parent::setActive("Resources");

		return View::make('plugins', $vars);
	}

	public function managePlugins(){
		if(Auth::check()){
			$groups = UserGroups::getGroups(Auth::user()->id);
			$check = true;
		}else{
			$check = false;
		}

		if($check && in_array(UserGroups::DEVELOPER, $groups)){
			parent::setActive('Developer');
			$vars['title'] = 'Manage Plugins';
			$vars['plugins'] = DB::table("plugins")->where('author', Auth::user()->id)->get();

			return View::make('developer.managePlugins', $vars);
		}else{
			return Redirect::to("http://wiki.battleplugins.com/w/index.php?title=BA_API_Tutorial");
		}
	}

	public function getPluginProfile($name){
		$plugin = DB::table('plugins')->where('name', $name)->first();
		if(count($plugin) > 0){
			$vars['title'] = $plugin->name;
			$vars['plugin'] = $plugin;
			$vars['author'] = UserSettings::getUsernameFromId($plugin->author);
			$vars['dev'] = Deploy::isDeveloperMode();

			$ci = Jenkins::getLatestBuild("http://ci.battleplugins.com", $plugin->name);
			$vars['lastBuild'] = array('ci' => $ci, 'name' => $plugin->name, 'author' => $plugin->author, 'bukkit' => $plugin->bukkit);

			return View::make('plugin-profile', $vars);
		}else{
			return Redirect::to('/plugins');
		}
	}

	public function addPlugin(){
		$slug = Input::get('pluginSlug');
		$project = ProjectInfo::getProjectInfo($slug);
		if(count($project) == 0){
			return Response::json(array("result"=>"error","reason"=>"That slug was not found."));
		}

		$plugins = DB::table("plugins")->where("name", $project['name'])->first();
		if(count($plugins) > 0){
			return Response::json(array("result"=>"error","reason"=>"That plugin already exists!"));
		}

		DB::table("plugins")->insert(array(
			"name" => $project['name'],
			"bukkit" => $project['slug']
		));
		return Response::json(array("result"=>"success"));
	}

	public function deletePlugin($plugin){
		$plugin = DB::table('plugins')->where('name', $plugin)->first();
		if(count($plugin) == 0 || $plugin->author != Auth::user()->id){
			return App::abort(401);
		}else{
			DB::table('plugins')->where('name', $plugin->name)->delete();
		}
	}

	public function getAddPluginForm(){
		return View::make('ajax.addPluginForm');
	}
}