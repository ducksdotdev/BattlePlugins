<?php


namespace App\Tools\Misc;


class UserSettings {

    public function modify($user, $key, $value) {
        if (!($user instanceof User))
            $user = User::find($user);

        if ($key == 'password')
            $value = Hash::make($value);

        $user->update([
            $key => $value
        ]);
    }

    public function deleteUser($user) {
        if (!($user instanceof User))
            $user = User::find($user);

        $user->alerts()->detach();
        $user->tasks()->update([
            'assignee_id' => null
        ]);

        $user->delete();
    }

}