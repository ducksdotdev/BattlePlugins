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

    /**
     * @param Alert $alert
     * @throws \Exception
     */
    public static function delete(Alert $alert) {
        foreach ($alert->users as $user)
            AlertRepository::detach($alert, $user);

        $alert->delete();
    }

    /**
     * @param Alert $alert
     * @param User $user
     * @throws \Exception
     */
    public static function detach(Alert $alert, User $user) {
        $user->alerts()->detach($alert->id);

        if (!count($alert->users))
            $alert->delete();
    }
}