<?php
/**
 * Created by IntelliJ IDEA.
 * User: Justin
 * Date: 5/24/2015
 * Time: 3:57 PM
 */

namespace App\Tools;


class VerifyHMAC
{
    public static function validateSignature($gitHubSignatureHeader, $payload)
    {
        $secret = env('GITHUB_WEBHOOK_SECRET');
        list ($algo, $gitHubSignature) = explode("=", $gitHubSignatureHeader);
        $payloadHash = hash_hmac($algo, $payload, $secret);
        return ($payloadHash == $gitHubSignature);
    }
}