<?php

namespace App\Tools\Security;


/**
 * Class VerifyHMAC
 * @package App\Tools\Security
 */
class VerifyHMAC {
    /**
     * @param $gitHubSignatureHeader
     * @param $payload
     * @return bool
     */
    public static function validateSignature($gitHubSignatureHeader, $payload) {
        $secret = env('GITHUB_WEBHOOK_SECRET');
        list ($algo, $gitHubSignature) = explode("=", $gitHubSignatureHeader);
        $payloadHash = hash_hmac($algo, $payload, $secret);
        return ($payloadHash == $gitHubSignature);
    }
}