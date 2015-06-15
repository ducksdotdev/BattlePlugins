<?php

namespace App\Tools\API\Transformers;

/**
 * Class userTransformer
 * @package App\Tools\Transformers
 */
class UserTransformer extends Transformer {

	/**
	 * @param $user
	 * @return array
	 */
	public function transform ($user){
		return [
			'id' => $user['id'],
			'alias' => $user['displayname'],
			'is_admin' => (boolean) $user['admin']
		];
	}

}