<?php namespace App\Tools\Queries;

use App\Models\ServerSettings;

class ServerSetting {
    public static function get($key) {
        return ServerSettings::whereKey($key)->pluck('value');
    }
}