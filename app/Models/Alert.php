<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Alert
 * @package App\Models
 */
class Alert extends Model {

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'content', 'color'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
