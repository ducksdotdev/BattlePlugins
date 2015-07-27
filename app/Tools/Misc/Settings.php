<?php

namespace App\Tools\Misc;

use App\Models\ServerSettings;

/**
 * Class Settings
 * @package App\Tools\Misc
 */
class Settings {
    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return ServerSettings::whereKey($key)->pluck('value');
    }

    /**
     * @param $setting
     */
    public static function toggle($setting) {
        $value = !static::get($setting);

        ServerSettings::firstOrCreate([
            'key' => $setting
        ])->update([
            'value'      => $value,
            'updated_by' => auth()->user()->id
        ]);
    }
}