<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerSettings extends Model {
    protected $table = 'server_settings';

    protected $fillable = ['key', 'value', 'updated_by'];

    public function user() {
        $this->belongsTo('App\Models\User');
    }
}
