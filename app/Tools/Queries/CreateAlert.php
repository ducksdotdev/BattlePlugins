<?php

namespace App\Tools\Queries;

use App\Models\Alert;
use App\Models\User;
use App\Models\UserAlert;

class CreateAlert {

    public static function make($user, $content) {
        if ($user instanceof User)
            $user = $user->id;

        $alert = new Alert();
        $alert->content = $content;
        $alert->save();

        $alert->users()->attach($user);
    }

}