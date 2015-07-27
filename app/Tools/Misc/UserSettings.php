<?php


namespace App\Tools\Misc;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSettings {

    public static function modify($user, $key, $value) {
        if (!($user instanceof User))
            $user = User::find($user);

        if ($key == 'password')
            $value = Hash::make($value);

        $user->update([
            $key => $value
        ]);
    }

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