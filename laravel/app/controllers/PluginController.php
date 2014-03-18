<?php

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
			$vars['plugin'] = DB::table("plugins")->get();

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
}