<?php

namespace App\Tools;

use Auth;
use Illuminate\Support\Facades\Log;

class Webhooks {

    public static function sendPayload ($url, $method, $payload = []) {
        $url = env("API_URL") . $url;

        $headers = array(
            'X-API-Key: ' . Auth::user()->api_key
        );

        if ($method == 'PATCH' || $method == 'PUT') {
            array_push($headers, 'Content-Type: x-www-form-urlencoded');
            $payload = http_build_query($payload);
            $url = $url . '?' . $payload;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_exec($ch);
        curl_close($ch);
    }

}