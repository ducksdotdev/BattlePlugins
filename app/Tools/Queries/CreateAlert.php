<?php

namespace App\Tools\Queries;

use App\Tools\Models\Alert;

class CreateAlert {

    public static function make($user, $content, $color = 'default') {
        Alert::create([
            'user'    => $user,
            'content' => $content,
            'color'   => strtolower($color)
        ]);
    }

}