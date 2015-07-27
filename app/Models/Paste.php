<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Paste
 * @package App\Models
 */
class Paste extends Model {

    /**
     * @var array
     */
    protected $fillable = ['slug', 'user_id', 'title', 'public'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'id');
    }
}
