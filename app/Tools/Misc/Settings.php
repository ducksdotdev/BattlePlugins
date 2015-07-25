<?php


namespace App\Tools\Misc;


class Settings {
    public static function get($key) {
        return ServerSettings::whereKey($key)->pluck('value');
    }

    public static function toggle($setting) {
        $value = !ServerSetting::get($setting);

        ServerSettings::firstOrCreate([
            'key' => $setting
        ])->update([
            'value'      => $value,
            'updated_by' => auth()->user()->id
        ]);
    }
}