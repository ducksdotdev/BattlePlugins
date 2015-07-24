<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Webhook
 * @package App
 */
class Webhook extends Model {

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'url', 'event'];

}
