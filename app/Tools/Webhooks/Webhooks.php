<?php

namespace App\Tools\Webhooks;

use App\Jobs\SendPayload;
use App\Tools\Models\Webhook;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Webhooks
{

    use DispatchesJobs;

    const TASK_CREATED = 'TASK_CREATED';
    const TASK_DELETED = 'TASK_DELETED';
    const TASK_UPDATED = 'TASK_UPDATED';
    const BLOG_CREATED = 'BLOG_CREATED';
    const BLOG_DELETED = 'BLOG_DELETED';
    const BLOG_UPDATED = 'BLOG_UPDATED';

    public static function getTypes()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    public function triggerWebhook($payload, $event)
    {
        $urls = Webhook::whereEvent($event)->lists('url');

        foreach ($urls as $url) {
            $this->dispatch(new SendPayload($url, 'POST', $payload));
        }
    }

    public function sendPayload($url, $method, $payload = [])
    {
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