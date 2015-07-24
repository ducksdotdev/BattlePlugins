<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildDownloads extends Model {
    protected $table = 'build_downloads';

    protected $fillable = ['build', 'downloads'];

    protected $primaryKey = 'build';
}
