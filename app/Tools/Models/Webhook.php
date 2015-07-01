<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Webhook
 * @package App
 */
class Webhook extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['user', 'url', 'event'];

}
