<?php

namespace App\Tools\API\Transformers;

use App\Tools\Models\User;
use Auth;

/**
 * Class TaskTransformer
 * @package App\Tools\Transformers
 */
class BlogTransformer extends Transformer {

	/**
	 * @param $blog
	 * @return array
	 */
	public function transform ($blog){
		return [
			'id' => (int) $blog['id'],
			'title' => $blog['title'],
			'content' => $blog['content'],
			'author' => User::find($blog['author'])['displayname'],
			'created_at' => $blog['created_at'],
			'updated_at' => $blog['updated_at']
		];
	}

}