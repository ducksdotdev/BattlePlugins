<?php
namespace BattleTools\API;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ProjectInfo{
	public static function getProjectInfo($slug){
		$key = "project.".$slug;
		return Cache::get($key, function () use ($key, $slug){
			$project = file_get_contents("https://api.curseforge.com/servermods/projects?search=".$slug);
			$project = json_decode($project);

			$plugins = DB::table("plugins")->where("bukkit", $slug)->first();
			if(count($plugins) > 0){
				Cache::forever($key, $project);
			}else{
				Cache::put($key, $project, Carbon::now()->addWeek());
			}

			return $project;
		});
	}
}
