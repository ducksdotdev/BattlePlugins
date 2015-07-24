<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

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

    public function alerts() {
        return $this->belongsToMany('App\Models\Alert');
    }

    public function blogs() {
        return $this->hasMany('App\Models\Blog');
    }

    public function pastes() {
        return $this->hasMany('App\Models\Paste');
    }

    public function webhooks() {
        return $this->hasMany('App\Models\Webhook');
    }

    public function tasks() {
        return $this->hasMany('App\Models\Task', 'assignee_id');
    }

    public function createdTasks() {
        return $this->hasMany('App\Models\Task');
    }
}
