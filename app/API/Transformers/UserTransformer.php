<?php

namespace App\API\Transformers;

/**
 * Class UserTransformer
 * @package App\Tools\API\Transformers
 */
class UserTransformer extends Transformer {

    /**
     * @param $user
     * @return array
     */
    public function transform($user) {
        return [
            'id' => $user['id'],
            'alias' => $user['displayname'],
            'is_admin' => (boolean)$user['admin']
        ];
    }

}