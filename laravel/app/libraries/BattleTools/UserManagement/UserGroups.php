<?php

namespace BattleTools\UserManagement;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserGroups {

    const BANNED = 0;
    const USER = 1;
    const ADMINISTRATOR = 2;
	const DEVELOPER = 3;

    public static function getGroupName($id) {
        switch ($id) {
            case self::BANNED:
                return "Banned";
            case self::USER:
                return "User";
            case self::ADMINISTRATOR:
                return "Administrator";
            case self::DEVELOPER:
                return "Developer";
        }
        throw new \Exception("Unknown group id $id");
    }

    private static function processData($data) {
        $groupList = array();
        foreach ($data as $item) {
            $groupList[] = intval($item->group);
        }
        return $groupList;
    }

    public static function getGroups($uid, $cache=true) {
        if ($cache) {
            if (!Cache::has('groups-' . $uid)) {
                $data = self::processData(DB::table("user_groups")->where("user_id", $uid)->get());
                Cache::put('groups-' . $uid, $data, 1440);
                return $data;
            } else {
                return Cache::get('groups-' . $uid);
            }
        } else {
            $data = self::processData(DB::table("user_groups")->where("user_id", $uid)->get());
            Cache::put('groups-' . $uid, $data, 1440);
            return $data;
        }
    }

    public static function hasGroup($uid, $group) {
        return (in_array($group, self::getGroups($uid)));
    }

    public static function addGroup($uid, $group) {
        if (!self::hasGroup($uid, $group)) {
            DB::table('user_groups')->insert(array("user_id" => $uid, "group" => $group));
            return self::getGroups($uid, false);
        }
    }

    public static function removeGroup($uid, $group) {
        if (self::hasGroup($uid, $group)) {
            DB::table('user_groups')->where("user_id", $uid)->where("group", $group)->delete();
            return self::getGroups($uid, false);
        }
    }

    public static function getUserByGroup($group){
        $data = DB::table('user_groups')->where("group", $group)->get();
        $user_ids = array();
        foreach($data as $row) {
            array_push($user_ids, $row->user_id);
        }

        return $user_ids;
    }

    public static function getAll() {
        $reflector = new \ReflectionClass(__CLASS__);
        return array_values($reflector->getConstants());
    }
}
