<?php

namespace App\API\Transformers;

/**
 * Class ShortUrlTransformer
 * @package App\API\Transformers
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