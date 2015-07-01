<?php

namespace App\Tools\API\Transformers;

/**
 * Class TaskTransformer
 * @package App\Tools\Transformers
 */
class ShortUrlTransformer extends Transformer {

    /**
     * @param $blog
     * @return array
     */
    public function transform($blog) {
        return [
            'url' => $blog['url'],
            'short_url' => $blog['content']
        ];
    }

}