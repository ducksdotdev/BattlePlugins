<?php
namespace BattleTools\API;

class ProjectInfo {
	public static function getProjectInfo($slug) {
		$project = file_get_contents("https://api.curseforge.com/servermods/projects?search=".$slug);
		$project = json_decode($project);

		return $project[0];
	}
}
