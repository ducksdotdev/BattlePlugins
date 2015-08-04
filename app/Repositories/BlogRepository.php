<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\User;

/**
 * Class BlogRepository
 * @package App\Repositories
 */
class BlogRepository {

    /**
     * @param $title
     * @param $content
     * @param $author
     */
    public static function create($title, $content, $author) {
        if ($author instanceof User)
            $author = $author->id;

        Blog::create([
            'title'   => $title,
            'content' => $content,
            'author'  => $author
        ]);
    }

    /**
     * @param $blog
     * @throws \Exception
     */
    public static function delete($blog) {
        if ($blog instanceof Blog)
            $blog->delete();
        else
            Blog::find($blog)->delete();
    }

    /**
     * @param $blog
     * @param array $data
     */
    public static function update($blog, array $data) {
        if ($blog instanceof Blog)
            $blog->update($data);
        else
            Blog::find($blog)->update($data);
    }

}