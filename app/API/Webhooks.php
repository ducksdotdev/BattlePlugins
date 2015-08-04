<?php

namespace App\API;

use App\Jobs\SendPayload;
use App\Models\Webhook;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Webhooks
 * @package App\API\Webhooks
 */
class Webhooks {

    use DispatchesJobs;

    const TASK_CREATED = 'TASK_CREATED';
    const TASK_DELETED = 'TASK_DELETED';
    const TASK_UPDATED = 'TASK_UPDATED';
    const BLOG_CREATED = 'BLOG_CREATED';
    const BLOG_DELETED = 'BLOG_DELETED';
    const BLOG_UPDATED = 'BLOG_UPDATED';

    /**
     * @return array
     */
    public static function getTypes() {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    /**
     * @param $url
     * @param $event
     */
    public static function create($url, $event) {
        $uid = Auth::user()->id;

        if (!$url)
            auth()->user()->webhooks()->whereEvent($event)->delete();
        else {
            Webhook::updateOrCreate([
                'event' => $event,
                'user_id' => $uid
            ])->update([
                'url' => $url
            ]);
        }
    }

    /**
     * @param $payload
     * @param $event
     */
    public function triggerWebhook($payload, $event) {
        $urls = Webhook::whereEvent($event)->lists('url');

        foreach ($urls as $url)
            $this->dispatch(new SendPayload($url, 'POST', $payload));
    }

    /**
     * @param $url
     * @param $method
     * @param array $payload
     */
    public function sendPayload($url, $method, $payload = []) {
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