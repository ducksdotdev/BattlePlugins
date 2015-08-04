<?php

namespace App\Tools;


use App\Repositories\PasteRepository;
use App\Repositories\ShortUrlRepository;

/**
 * Class SlugGenerator
 * @package App\Tools\URL
 */
class SlugGenerator {

    /**
     * @return string
     */
    public static function generate() {
        $slug = str_random(6);

        while (PasteRepository::getBySlug($slug) || ShortUrlRepository::getBySlug($slug))
            $slug = str_random(6);

        return $slug;
    }

}