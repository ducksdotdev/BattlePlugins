<?php

namespace App\Tools\API\Traits;

use App\Tools\Models\Alert;
use App\Tools\Models\User;

trait AlertUser {

    protected static function bootAlertUser() {
        foreach (static::getAlertModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                if ($model->assigned_to != 0) {
                    Alert::create([
                        'user' => $model->assigned_to,
                        'content' => "A task has been assigned to you by " . User::find($model->creator)->displayname,
                    ]);
                } else {
	                foreach(User::all() as $user){
		                Alert::create([
			                'user' => $user->id,
			                'content' => "A task has been created by " . User::find($model->creator)->displayname,
		                ]);
	                }
                }
            });
        }
    }

    protected static function getAlertModelEvents() {
        return isset(static::$webhookEvents) ? static::$webhookEvents : ['created', 'updated'];
    }

}