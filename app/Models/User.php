<?php

namespace App\Models;

use App\Tools\Misc\UserSettings;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'admin', 'displayname', 'api_key'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function boot() {
        parent::boot();

        static::created(function ($model) {
            UserSettings::togglePermissionNode($model->id, UserSettings::USE_API);
            UserSettings::togglePermissionNode($model->id, UserSettings::CREATE_PASTE);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alerts() {
        return $this->belongsToMany('App\Models\Alert');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs() {
        return $this->hasMany('App\Models\Blog', 'author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pastes() {
        return $this->hasMany('App\Models\Paste');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function webhooks() {
        return $this->hasMany('App\Models\Webhook');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks() {
        return $this->hasMany('App\Models\Task', 'assignee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTasks() {
        return $this->hasMany('App\Models\Task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permission() {
        return $this->hasMany('App\Models\Permission');
    }
}
