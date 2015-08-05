<?php

namespace App\API;

use App\Models\User;
use Carbon\Carbon;

/**
 * Class GenerateApiKey
 * @package App\API
 */
class GenerateApiKey {

    /**
     * @param $user
     */
    public static function changeKey($user) {
        if (!($user instanceof User))
            $user = User::find($user);

        $user->api_key = static::generateKey();
        $user->save();
    }

    /**
     * @return string
     */
    public static function generateKey() {
        return md5(Carbon::now());
    }

}