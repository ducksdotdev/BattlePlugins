<?php
namespace BattleTools\Util;

class ListSentence {

    private static function lastReplace($search, $replace, $subject) {
        return preg_replace('~(.*)' . preg_quote($search, '~') . '(.*?)~', '$1' . $replace . '$2', $subject, 1);
    }

    public static function toSentence($array, $glue="and") {
        if (count($array) == 2) {
            return implode(" $glue ", $array);
        } else {
            return self::lastReplace(", ", " $glue ", implode(", ", $array));
        }
    }

    public static function startsWith($haystack, $needle){
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    public static function endsWith($haystack, $needle){
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

}
