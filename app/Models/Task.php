<?php

namespace App\Models;

use App\API\Traits\DispatchPayload;
use App\Tools\Queries\CreateAlert;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model {

    use DispatchPayload;

    /**
     * @var array
     */
    protected $fillable = ['title', 'user_id', 'content', 'assignee_id', 'public', 'completed'];

    public static function boot() {
        parent::boot();

        foreach (['created', 'updated'] as $event) {
            static::$event(function ($model) use ($event) {
                if ($model->assignee_id && !$model->status) {
                    $message = "A task has been assigned to you by " . User::find($model->user_id)->displayname;
                    CreateAlert::make($model->assignee_id, $message);
                }
            });
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee() {
        return $this->belongsTo('App\Models\User', 'assignee_id');
    }

}
