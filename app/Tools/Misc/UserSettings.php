<?php


namespace App\Tools\Misc;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSettings
 * @package App\Tools\Misc
 */
class UserSettings {

    /**
     * @param $user
     * @param $key
     * @param $value
     */
    public static function modify($user, $key, $value) {
        if (!($user instanceof User))
            $user = User::find($user);

        if ($key == 'password')
            $value = Hash::make($value);

        $user->update([
            $key => $value
        ]);
    }

    /**
     * @param $user
     * @throws \Exception
     */
    public static function deleteUser($user) {
        if (!($user instanceof User))
            $user = User::find($user);

        $user->alerts()->detach();
        $user->tasks()->update([
            'assignee_id' => null
        ]);

        $user->delete();
    }

}