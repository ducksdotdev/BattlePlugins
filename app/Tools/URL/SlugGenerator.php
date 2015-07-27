<?php

namespace App\Tools\URL;


use App\Models\Paste;
use App\Models\ShortUrl;

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

        while (Paste::whereSlug($slug)->first() || ShortUrl::whereSlug($slug)->first())
            $slug = str_random(6);

        return $slug;
    }

}