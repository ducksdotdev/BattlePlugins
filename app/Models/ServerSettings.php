<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServerSettings
 * @package App\Models
 */
class ServerSettings extends Model {
    /**
     * @var string
     */
    protected $table = 'server_settings';

    /**
     * @var array
     */
    protected $fillable = ['key', 'value', 'updated_by'];

    /**
     *
     */
    public function user() {
        $this->belongsTo('App\Models\User');
    }
}
