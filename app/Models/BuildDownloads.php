<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BuildDownloads
 * @package App\Models
 */
class BuildDownloads extends Model {
    /**
     * @var string
     */
    protected $table = 'build_downloads';

    /**
     * @var array
     */
    protected $fillable = ['build', 'downloads'];

    /**
     * @var string
     */
    protected $primaryKey = 'build';
}
