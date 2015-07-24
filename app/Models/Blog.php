<?php namespace App\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

    use DispatchPayload;

    protected $fillable = ['title', 'content', 'author'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'author', 'id');
    }
}
