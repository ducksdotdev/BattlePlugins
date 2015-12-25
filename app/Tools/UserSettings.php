<?php


namespace App\Tools;

use App\API\GenerateApiKey;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSettings
 * @package App\Tools\Misc
 */
class UserSettings {

    const CREATE_BLOG = 'blog.create';
    const MODIFY_BLOG = 'blog.modify';
    const DELETE_BLOG = 'blog.delete';
    const BLOG_ADMIN = 'blog.admin';
    const VIEW_TASK = 'task.view';
    const CREATE_TASK = 'task.create';
    const MODIFY_TASK = 'task.modify';
    const DELETE_TASK = 'task.delete';
    const ADMIN_PANEL = 'admin.access';
    const CREATE_ALERT = 'admin.alert';
    const DELETE_ALERT = 'admin.alert.delete';
    const CREATE_USER = 'admin.user.create';
    const MODIFY_USER = 'admin.user.modify';
    const DELETE_USER = 'admin.user.delete';
    const VIEW_PERMISSIONS = 'admin.user.viewpermissions';
    const DELETE_SHORTURL = 'admin.deleteshorturl';
    const MANAGE_CONTENT = 'admin.cms';
    const VIEW_API_KEYS = 'admin.apikeys';
    const HIDE_API_KEY = 'admin.apikeys.hide';
    const VIEW_PASTES = 'admin.pastes';
    const DELETE_PASTES_AS_ADMIN = 'admin.pastes.delete';
    const VIEW_ANALYTICS = 'admin.analytics';
    const DEVELOPER = 'developer';
    const CREATE_PASTE = 'paste.create';
    const MODIFY_PASTE = 'paste.modify';
    const USE_API = 'api.use';
    const USE_WEBHOOKS = 'api.webhooks';
    const MANAGE_BUILDS = 'download.togglestable';
    const FORCE_2FA = '2fa.force';

    /**
     * @return array
     */
    public static function getPossible() {
        $oClass = new \ReflectionClass(__CLASS__);

        return array_sort($oClass->getConstants(), function ($value) {
            return $value;
        });
    }

    /**
     * @param $email
     * @param $password
     * @param $displayname
     * @return mixed
     */
    public static function create($email, $password, $displayname) {
        $id = User::insertGetId([
            'email'    => $email,
            'password' => Hash::make($password),
            'displayname' => $displayname,
            'api_key'  => GenerateApiKey::generateKey()
        ]);

        static::togglePermissionNode($id, static::USE_API);
        static::togglePermissionNode($id, static::CREATE_PASTE);
        static::togglePermissionNode($id, static::MODIFY_PASTE);

        return $id;
    }

    /**
     * @param $user
     * @param $node
     */
    public static function togglePermissionNode($user, $node) {
        if (!($user instanceof User))
            $user = User::find($user);

        if (static::hasNode($user, $node))
            $user->permission()->whereNode($node)->delete();
        else {
            Permission::create([
                'user_id' => $user->id,
                'node' => $node
            ]);
        }
    }

    /**
     * @param $user
     * @param $node
     * @return bool
     */
    public static function hasNode($user, $node) {
        if ($user instanceof User)
            $user = $user->id;

        return (bool)count(Permission::whereUserId($user)->whereNode($node)->first());
    }

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

    /**
     * @param $user
     * @throws \Exception
     */
    public static function delete($user) {
        if (!($user instanceof User))
            $user = User::find($user);

        $user->alerts()->detach();
        $user->blogs()->delete();
        $user->permission()->delete();
        $user->delete();
    }
}