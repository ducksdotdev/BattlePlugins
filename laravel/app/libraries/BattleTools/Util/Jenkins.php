<?php

namespace BattleTools\Util;

use Illuminate\Support\Facades\Log;
use Requests;

class Jenkins {

	public static function getLatestBuild($url, $job){
		try {
			$request = Requests::get($url . "/job/" . $job . "/lastSuccessfulBuild/", array(), array('timeout' => 3));
		}catch(Exception $e){
			self::timeout();
		}

		if($request->success) {
			$matches = array();
			$match = preg_match('/\<title\>[A-Za-z0-9-_]+ \#([0-9]+) \[Jenkins\]\<\/title\>/i', $request->body, $matches);
			if ($match == 0) {
				return $dne;
			} else {
				$buildnum = $matches[1];
				return array(
					'exists' => true,
					'build' => $buildnum,
					'url' => $url . '/job/' . $job . '/' . $buildnum
				);
			}
		}else{
			self::timeout();
		}
	}

	private function timeout(){
		Log::emergency("It looks like the CI server is down at $url.");
		return array(
			'exists' => false,
			'build' => 'None',
			'url' => '#'
		);
	}

}
