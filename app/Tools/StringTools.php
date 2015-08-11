<?php
/**
 * Created by IntelliJ IDEA.
 * User: justin
 * Date: 8/11/15
 * Time: 12:06 PM
 */

namespace App\Tools;


/**
 * Class StringTools
 * @package App\Tools
 */
class StringTools {

    /**
     * @param $email
     * @return string
     */
    public static function hideEmail($email) {
        $mail_segments = explode("@", $email);
        $mail_segments[0] = str_repeat("*", strlen($mail_segments[0]) - 1);

        return substr($email, 0, 1) . implode("@", $mail_segments);
    }
}