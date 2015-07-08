<?php

namespace App\Tools\Models;

use App\Tools\API\Traits\DispatchPayload;
use App\Tools\Queries\CreateAlert;
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

        foreach (['created', 'updated'] as $event) {
            static::$event(function ($model) use ($event) {
                if ($model->assigned_to != 0 && !$model->status) {
                    $message = "A task has been assigned to you by " . User::find($model->creator)->displayname;
                    CreateAlert::make($model->assigned_to, $message);
                }
            });
        }
    }

}
