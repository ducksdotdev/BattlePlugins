<?php

namespace App\Queries;

use App\Models\Alert;
use App\Models\User;
use App\Models\UserAlert;

/**
 * Class CreateAlert
 * @package App\Queries
 */
class CreateAlert {

    /**
     * @param $content
     * @return mixed
     */
    public static function make($content) {
        $id = Alert::insertGetId([
            'content' => $content
        ]);

        return Alert::find($id);
    }

    /**
     * @param Alert $alert
     * @param User $user
     */
    public static function attach(Alert $alert, User $user) {
        $alert->users()->attach($user);
    }

}