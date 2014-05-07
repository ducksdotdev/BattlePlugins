<?php

namespace BattleTools\Util;

class Jenkins {

	public static function getLatestBuild($url, $job){
		$request = Requests::get($url . "/job/" . $job . "/lastSuccessfulBuild/", array(), array(
			'timeout' => '3'
		));

		if($request->success) {
			$matches = array();
			$match = preg_match('/\<title\>[A-Za-z0-9-_]+ \#([0-9]+) \[Jenkins\]\<\/title\>/i', $contents, $matches);
			if ($match == 0) {
				$array = array(
					'exists' => false,
					'build' => 'None',
					'url' => '#'
				);
			} else {
				$buildnum = $matches[1];
				$array = array(
					'exists' => true,
					'build' => $buildnum,
					'url' => $url . '/job/' . $job . '/' . $buildnum
				);
			}
			return $array;
		}else{
			Log::emergency("It looks like the CI server is down at $url");
			return array('exists'=>false);
		}
	}

}
