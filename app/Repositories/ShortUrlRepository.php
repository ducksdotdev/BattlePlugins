<?php


namespace App\Tools\Repositories;


use App\Models\ShortUrl;

/**
 * Class ShortUrlRepository
 * @package App\Tools\Repositories
 */
class ShortUrlRepository {

    /**
     * @param $slug
     */
    public static function deleteBySlug($slug) {
        ShortUrl::whereSlug($slug)->delete();
    }

    /**
     * @param $url
     */
    public static function deleteByUrl($url) {
        ShortUrl::whereUrl($url)->delete();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function getBySlug($slug) {
        return ShortUrl::whereSlug($slug)->first();
    }

    /**
     * @param $slug
     * @param array $data
     */
    public static function update($slug, array $data) {
        ShortUrl::whereSlug($slug)->update($data);
    }

}