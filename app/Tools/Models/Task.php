<?php

namespace App\Tools\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    use DispatchPayload;

    public $timestamps = false;

    protected $fillable = ['title', 'creator', 'content', 'assigned_to', 'public', 'status'];
}
