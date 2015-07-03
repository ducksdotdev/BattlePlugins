<?php namespace App\Tools\Queries;

use App\Tools\Models\ServerSettings;

class ServerSetting {
    public static function get($key) {
        return ServerSettings::whereKey($key)->pluck('value');
    }
}