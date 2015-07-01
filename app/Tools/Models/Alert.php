<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model {

    protected $fillable = ['user', 'content', 'color'];

}
