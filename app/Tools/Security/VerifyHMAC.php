<?php

namespace App\Tools\Security;


class VerifyHMAC {
    public static function validateSignature($gitHubSignatureHeader, $payload) {
        $secret = env('GITHUB_WEBHOOK_SECRET');
        list ($algo, $gitHubSignature) = explode("=", $gitHubSignatureHeader);
        $payloadHash = hash_hmac($algo, $payload, $secret);
        return ($payloadHash == $gitHubSignature);
    }
}