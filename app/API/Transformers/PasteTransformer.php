<?php

namespace App\API\Transformers;

use App\Models\User;
use Auth;

/**
 * Class PasteTransformer
 * @package App\API\Transformers
 */
class PasteTransformer extends Transformer {

    /**
     * @param $paste
     * @return array
     */
    public function transform($paste) {

        $content = file_get_contents(storage_path() . '/app/pastes/' . $paste['slug'] . '.txt');

        return [
            'id' => (int)$paste['id'],
            'title' => $paste['title'],
            'slug' => $paste['slug'],
            'author' => User::find($paste['creator'])['displayname'],
            'content' => $content,
            'public' => (bool)$paste['public'],
            'created_at' => $paste['created_at'],
            'updated_at' => $paste['updated_at']
        ];
    }

}