<?php namespace App\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

    use DispatchPayload;

    protected $fillable = ['title', 'content', 'author'];

    public function author() {
        return $this->belongTo('App\Models\User');
    }
}
