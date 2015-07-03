<?php

namespace App\Tools\API\Traits;

use App\Tools\Models\User;
use App\Tools\Queries\CreateAlert;

trait AlertUser {

    protected static function bootAlertUser() {
        foreach (static::getAlertModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                if ($model->assigned_to != 0) {
                    $message = "A task has been assigned to you by " . User::find($model->creator)->displayname;
                    CreateAlert::make($model->assigned_to, $message);
                }
                else {
                    foreach (User::all() as $user) {
                        $message = "A task has been created by " . User::find($model->creator)->displayname;
                        CreateAlert::make($user->id, $message);
                    }
                }
            });
        }
    }

    protected static function getAlertModelEvents() {
        return isset(static::$webhookEvents) ? static::$webhookEvents : ['created', 'updated'];
    }

}