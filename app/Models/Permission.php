<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    protected $fillable = ['user_id', 'node'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
