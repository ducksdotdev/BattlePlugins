<?php

namespace App\Tools\URL;


use App\Tools\Models\Paste;
use App\Tools\Models\ShortUrl;

class SlugGenerator {

    public static function generate() {
        $slug = str_random(6);

        while (Paste::whereSlug($slug)->first() || ShortUrl::wherePath($slug)->first())
            $slug = str_random(6);

        return $slug;
    }

}