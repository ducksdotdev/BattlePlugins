<?php

namespace App\Tools\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model {
    use DispatchPayload;

    public $timestamps = false;

    protected $fillable = ['title', 'creator', 'content', 'assigned_to', 'public', 'status'];

    public static function boot() {
        parent::boot();

        static::created(function ($model) {
            if ($model->assigned_to != 0) {
                Alert::create([
                    'user' => $model->assigned_to,
                    'content' => "A task has been assigned to you by " . User::find($model->creator)->displayname,
                ]);
            }
        });
    }
}
