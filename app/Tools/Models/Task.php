<?php

namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{

    public $timestamps = false;
    protected $fillable = ['title', 'content', 'assigned_to', 'public', 'status'];

}
