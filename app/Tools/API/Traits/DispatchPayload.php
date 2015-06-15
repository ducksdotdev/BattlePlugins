<?php

namespace App\Tools\API\Traits;

use App\Tools\Webhooks\Webhooks;
use Illuminate\Support\Facades\Config;
use ReflectionClass;

trait DispatchPayload
{

    protected static function bootDispatchPayload()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                (new Webhooks)->triggerWebhook($model, $model->getActivityName($event));
            });
        }
    }

    protected static function getModelEvents()
    {
        return isset(static::$webhookEvents) ? static::$webhookEvents : Config::get('api.webhook_methods');
    }

    protected function getActivityName($action)
    {
        $name = (new ReflectionClass($this))->getShortName();

        return strtoupper($action . '_' . $name);
    }

}