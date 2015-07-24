<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paste extends Model {

    protected $fillable = ['slug', 'user_id', 'title', 'public'];

    public function creator() {
        return $this->belongsTo('App\Models\User', 'id');
    }
}
