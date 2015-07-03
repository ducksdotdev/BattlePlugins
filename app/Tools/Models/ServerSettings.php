<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class ServerSettings extends Model {
    public $timestamps = false;

    protected $table = 'server_settings';

    protected $fillable = ['key', 'value'];

    public $primaryKey = 'key';

}
