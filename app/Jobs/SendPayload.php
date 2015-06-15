<?php

namespace App\Jobs;

use App\Tools\Webhooks\SendPayload as Send;
use Illuminate\Contracts\Bus\SelfHandling;

class SendPayload extends Job implements SelfHandling
{
    private $url, $method, $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $method, $payload = [])
    {
        $this->url = $url;
        $this->method = $method;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Send::sendPayload($this->url, $this->method, $this->payload);
    }
}
