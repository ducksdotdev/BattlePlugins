<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $table = 'shorturls';

    protected $fillable = ['url', 'path', 'creator'];

    public $timestamps = false;
}
