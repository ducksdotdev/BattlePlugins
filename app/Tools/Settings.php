<?php

namespace App\Tools;

use App\Models\ServerSettings;

/**
 * Class Settings
 * @package App\Tools\Misc
 */
class Settings {
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

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return ServerSettings::whereKey($key)->pluck('value');
    }
}