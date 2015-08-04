<?php

namespace App\Tools;


/**
 * Class StringTools
 * @package App\Tools
 */
class StringTools {

    /**
     * @param $array
     * @param string $delimiter
     * @return string
     */
    public static function arrayToList($array, $delimiter = ',') {
        return rtrim(implode("$delimiter ", $array), "$delimiter ");
    }

}