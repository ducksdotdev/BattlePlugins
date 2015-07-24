<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionBuilds extends Model {
    protected $table = 'production_builds';

    protected $fillable = ['build'];

    protected $primaryKey = 'build';
}
