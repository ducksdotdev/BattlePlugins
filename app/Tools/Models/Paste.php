<?php namespace App\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Paste extends Model {

    protected $fillable = ['slug', 'creator', 'title', 'public'];

}
