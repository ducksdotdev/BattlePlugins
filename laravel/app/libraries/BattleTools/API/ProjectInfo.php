<?php
namespace BattleTools\API;

class ProjectInfo{
	public static function getProjectInfo($slug){
		return Cache::get("project.".$slug, function () use ($slug){
			$project = file_get_contents("https://api.curseforge.com/servermods/projects?search=".$slug);
			$project = json_decode($project);

			Cache::put("project.".$slug, $project, Carbon::now()->addWeek());

			return $project;
		});
	}
}
