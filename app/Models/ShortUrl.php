<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShortUrl
 * @package App\Models
 */
class ShortUrl extends Model {
    /**
     * @var string
     */
    protected $table = 'shorturls';

    /**
     * @var array
     */
    protected $fillable = ['url', 'slug', 'creator'];
}
