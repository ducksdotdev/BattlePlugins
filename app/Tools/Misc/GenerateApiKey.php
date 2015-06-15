<?php

namespace App\Tools\Misc;


use App\Tools\Models\User;

class GenerateApiKey {

	public static function generateKey(){
		$apiKey = str_random(32);

		// Prevent collisions:
		while(User::where('api_key', $apiKey)->first())
			$apiKey = str_random(32);

		return $apiKey;
	}

}