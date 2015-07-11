<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class BuildDownloads extends Model
{
    protected $table = 'build_downloads';

    protected $fillable = ['build','downloads'];

    public $timestamps = false;

    public $primaryKey = 'build';
}
