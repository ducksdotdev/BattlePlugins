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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
}
