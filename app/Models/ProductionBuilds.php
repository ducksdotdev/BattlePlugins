<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionBuilds
 * @package App\Models
 */
class ProductionBuilds extends Model {
    /**
     * @var string
     */
    protected $table = 'production_builds';

    /**
     * @var array
     */
    protected $fillable = ['build'];

    /**
     * @var string
     */
    protected $primaryKey = 'build';
}
