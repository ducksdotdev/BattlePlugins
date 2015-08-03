<?php


namespace App\Tools\Repositories;


use App\Models\Paste;
use App\Models\ShortUrl;

/**
 * Class PasteRepository
 * @package App\Tools\Repositories
 */
class PasteRepository {

    /**
     * @param $paste
     * @throws \Exception
     */
    public static function delete($paste) {
        if (!($paste instanceof Paste))
            $paste = Paste::find($paste);

        ShortUrlRepository::deleteBySlug($paste->slug);
        ShortUrl::deleteByUrl(action('PasteController@getRawPaste', ['slug' => $paste->slug]));
        ShortUrl::deleteByUrl(action('PasteController@getDownloadPaste', ['slug' => $paste->slug]));
        unlink(storage_path() . "/app/pastes/" . $paste->slug . ".txt");
        $paste->delete();
    }

    /**
     * @param $slug
     */
    public static function deleteBySlug($slug) {
        static::delete(static::getBySlug($slug)->id);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function getBySlug($slug) {
        return Paste::whereSlug($slug)->first();
    }

}