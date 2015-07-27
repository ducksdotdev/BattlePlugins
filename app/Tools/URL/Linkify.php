<?php

namespace App\Tools\URL;

use Illuminate\Html\HtmlFacade as HTML;

/**
 * Class Linkify
 * @package App\Tools\URL
 */
class Linkify {

    /**
     * @param $content
     * @return string
     */
    public static function link($content) {
        $paragraphs = preg_split('/[\n]/', $content);
        $newContent = '';
        foreach ($paragraphs as $paragraph) {
            $words = preg_split('/[\s]/', $paragraph);
            foreach ($words as $word) {
                if (starts_with($word, 'http')) {
                    $word = HTML::link(htmlentities($word));
                }

                $newContent = $newContent . ' ' . $word;
            }

            $newContent = $newContent . '<br/>';
        }

        return $newContent;
    }

}