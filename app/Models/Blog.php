<?php namespace App\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * @package App\Models
 */
class Blog extends Model {

    use DispatchPayload;

    /**
     * @var array
     */
    protected $fillable = ['title', 'content', 'author'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User', 'author', 'id');
    }
}
