<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model {
    protected $table = 'shorturls';

    protected $fillable = ['url', 'slug', 'creator'];
}
