<?php

namespace App\Repositories;

use App\Models\Alert;
use App\Models\User;


/**
 * Class AlertRepository
 * @package App\Repositories
 */
class AlertRepository {
    /**
     * @param $content
     * @return mixed
     */
    public static function create($content, $users) {
        $id = Alert::insertGetId([
            'content' => $content
        ]);

        $alert = Alert::find($id);

        foreach ($users as $user)
            static::attach($alert, $user);

        return $alert;
    }

    /**
     * @param Alert $alert
     * @param User $user
     */
    public static function attach(Alert $alert, User $user) {
        $alert->users()->attach($user);
    }
}