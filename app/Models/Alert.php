<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model {

    protected $fillable = ['user_id', 'content', 'color'];

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
