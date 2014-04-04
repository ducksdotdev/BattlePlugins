<?php
namespace BattleTools\API;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProjectInfo{
	public static function getProjectInfo($slug){
		if(preg_match("/[^a-zA-Z0-9]+/", $slug)){
			return array();
		}

		$key = "project.".$slug;

		return Cache::get($key, function () use ($key, $slug){
			$project = @file_get_contents("https://api.curseforge.com/servermods/projects?search=".$slug);

			if($project === false){
				return array();
			}

			$project = json_decode($project);
			if(count($project) == 0){
				return array();
			}

			$plugins = DB::table("plugins")->where("bukkit", $slug)->first();
			if(count($plugins) > 0){
				Cache::forever($key, $project);
			}else{
				Cache::put($key, $project, Carbon::now()->addWeek());
			}

			return $project;
		});
	}

	public static function getFiles($slug){
		$project = self::getProjectInfo($slug)[0];
		$files = @file_get_contents("https://api.curseforge.com/servermods/files?projectIds=".$project->id);

		if($files === false){
			return array();
		}

		return json_decode($files);
	}
}
