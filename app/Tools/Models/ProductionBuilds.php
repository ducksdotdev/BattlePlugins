<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionBuilds extends Model
{
    protected $table = 'production_builds';

    protected $fillable = ['id'];

    public $timestamps = false;
}
