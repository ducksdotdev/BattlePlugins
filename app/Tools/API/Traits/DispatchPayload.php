<?php

namespace App\Tools\API\Traits;

use App\Tools\Webhooks\Webhooks;
use Illuminate\Support\Facades\Config;
use ReflectionClass;

trait DispatchPayload {

    protected static function bootDispatchPayload() {
        foreach (static::getDispatchModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                (new Webhooks)->triggerWebhook($model, $model->getDispatchActivityName($event));
            });
        }
    }

    protected static function getDispatchModelEvents() {
        return isset(static::$webhookEvents) ? static::$webhookEvents : Config::get('api.webhook_methods');
    }

    protected function getDispatchActivityName($action) {
        $name = (new ReflectionClass($this))->getShortName();

        return strtoupper($name . '_' . $action);
    }

}