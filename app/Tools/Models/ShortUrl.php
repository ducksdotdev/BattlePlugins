<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected static $webhookEvents = [];
    public $timestamps = false;
    protected $table = 'shorturls';
    protected $fillable = ['url', 'path', 'creator'];
}
