<?php

namespace BattleTools\Util;

class Jenkins {

	public static function getLatestBuild($url, $job){
		return array(
			'exists' => false
		);

//		$ctx = stream_context_create(array(
//				'http' => array(
//					'timeout' => 100
//				)
//			)
//		);
//
//		$contents = @file_get_contents($url . "/job/" . $job . "/lastSuccessfulBuild/", 0, $ctx);
//		$matches = array();
//		$match = preg_match('/\<title\>[A-Za-z0-9-_]+ \#([0-9]+) \[Jenkins\]\<\/title\>/i', $contents, $matches);
//		if ($match == 0){
//			$array = array(
//				'exists' => false,
//				'build' => 'None',
//				'url' => '#'
//			);
//		}else{
//			$buildnum = $matches[1];
//			$array = array(
//				'exists' => true,
//				'build' => $buildnum,
//				'url' => $url.'/job/'.$job.'/'.$buildnum
//			);
//		}
//		return $array;
	}

}
