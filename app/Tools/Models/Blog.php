<?php namespace App\Tools\Models;

use App\Tools\API\Traits\DispatchPayload;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

    use DispatchPayload;

	protected $fillable = ['title','content','author'];

}
