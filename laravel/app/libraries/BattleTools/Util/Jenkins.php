<?php

namespace BattleTools\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Jenkins {

	public static function getLatestBuild($url, $job) {
		try {
			$request = \Requests::get($url . "/job/" . $job . "/lastSuccessfulBuild/", array(), array('timeout' => 5));
		}catch (\Requests_Exception $e) {
			return self::timeout($url);
		}

		if ($request->success) {
			$matches = array();
			$match = preg_match('/\<title\>[A-Za-z0-9-_]+ \#([0-9]+) \[Jenkins\]\<\/title\>/i', $request->body, $matches);
			if ($match == 0) {
				return self::timeout($url);
			} else {
				$buildnum = $matches[1];
				return array(
					'exists' => true,
					'build' => $buildnum,
					'url' => $url . '/job/' . $job . '/' . $buildnum
				);
			}
		} else {
			return self::timeout($url);
		}
	}

	private static function timeout($url){
		Log::emergency("It looks like the CI server is down at $url.");
		return array(
			'exists' => false,
			'build' => 'CI Server is currently down',
			'url' => '#'
		);
	}

}
