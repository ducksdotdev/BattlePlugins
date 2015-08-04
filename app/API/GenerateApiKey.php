<?php

namespace App\Tools\API;


use App\Models\User;

/**
 * Class GenerateApiKey
 * @package App\Tools\API
 */
class GenerateApiKey {

    /**
     * @param $user
     */
    public static function changeKey($user) {
        if (!($user instanceof User))
            $user = User::find($user);

        $user->api_key = GenerateApiKey::generateKey();
        $user->save();
    }

    /**
     * @return string
     */
    public static function generateKey() {
        $apiKey = str_random(32);

        // Prevent collisions:
        while (User::where('api_key', $apiKey)->first())
            $apiKey = str_random(32);

        return $apiKey;
    }

}