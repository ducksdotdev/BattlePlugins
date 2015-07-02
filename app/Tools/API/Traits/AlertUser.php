<?php

namespace App\Tools\API\Traits;

trait AlertUser {

    protected static function bootAlertUser() {
        foreach (static::getAlertModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                if ($model->assigned_to != 0) {
                    Alert::create([
                        'user' => $model->assigned_to,
                        'content' => "A " . str_singular($model->getTable()) . " has been assigned to you by " . User::find($model->creator)->displayname,
                    ]);
                }
            });
        }
    }

    protected static function getAlertModelEvents() {
        return isset(static::$webhookEvents) ? static::$webhookEvents : ['created', 'updated'];
    }

}