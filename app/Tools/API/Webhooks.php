<?php

namespace App\Tools\API;

use App\Jobs\SendPayload;
use App\Tools\Models\Webhook;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Webhooks
{

    use DispatchesJobs;

    const TASK_CREATED = 11;
    const TASK_DELETED = 12;
    const TASK_MODIFIED = 13;
    const BLOG_CREATED = 24;
    const BLOG_DELETED = 25;
    const BLOG_MODIFIED = 26;

    public static function getTypes()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    public function sendPayload($payload, $event)
    {
        $urls = Webhook::where('event', $event)->lists('url');

        foreach ($urls as $url) {
            $this->dispatch(new SendPayload($url, 'POST', $payload));
        }
    }

}