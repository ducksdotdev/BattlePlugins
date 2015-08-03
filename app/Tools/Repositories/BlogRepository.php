<?php

namespace App\Tools\Repositories;

use App\Models\Blog;
use App\Models\User;

class BlogRepository {

    public static function create($title, $content, $author) {
        if ($author instanceof User)
            $author = $author->id;

        Blog::create([
            'title' => $title,
            'content' => $content,
            'author' => $author
        ]);
    }

    public static function delete($blog) {
        if ($blog instanceof Blog)
            $blog->delete();
        else
            Blog::find($blog)->delete();
    }

    public static function update($blog, $update) {
        if ($blog instanceof Blog)
            $blog->update($update);
        else
            Blog::find($blog)->update($update);
    }

}