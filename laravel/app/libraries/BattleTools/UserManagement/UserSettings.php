<?php

namespace BattleTools\UserManagement;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserSettings {

    public static function set($uid, $key, $value) {
        if ($value == null) {
            self::delete($uid, $key);
            return;
        }
        if (self::get($uid, $key) == null) {
            //insert
            DB::table("user_settings")->insert(array("user_id" => $uid, "key" => $key, "value" => $value));
        } else {
            //update
            DB::table("user_settings")->where("user_id", $uid)->where("key", $key)->update(array("value" => $value));
        }
        if ($key == "email") {
            self::getGravatarString($uid, false);
        }
        return self::get($uid, $key, false); //force refresh
    }

    public static function get($uid, $key, $cache=true) {
        if ($cache) {
            if (!Cache::has('usettings-' . $uid . "-" . $key)) {
                $data = DB::table('user_settings')->where("user_id", $uid)->where("key", $key)->first();
                if ($data != null) {
                    $data = $data->value;
                }
                Cache::forever('usettings-' . $uid . "-" . $key, $data);
                return $data;
            } else {
                return Cache::get('usettings-' . $uid . "-" . $key);
            }
        } else {
            $data = DB::table('user_settings')->where("user_id", $uid)->where("key", $key)->first();
            if ($data != null) {
                $data = $data->value;
            }
            Cache::forever('usettings-' . $uid . "-" . $key, $data);
            return $data;
        }
    }

    public static function delete($uid, $key) {
        DB::table('user_settings')->where('user_id', $uid)->where("key", $key)->delete();
        Cache::forget('usettings-' . $uid . "-" . $key);
    }

    public static function getIdFromUsername($name){
        return DB::table("users")->where("username", $name)->pluck("id");
    }

    public static function getUsernameFromId($uid){
        return DB::table("users")->where("id", $uid)->pluck("username");
    }
}
