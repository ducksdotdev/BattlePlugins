<?php

namespace App\Tools\API\Traits;

use App\Tools\Webhooks\Webhooks;
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
        if (isset(static::$webhookEvents))
            return static::$webhookEvents;

        return ['created', 'deleted', 'updated'];
    }

    protected function getActivityName($action)
    {
        $name = (new ReflectionClass($this))->getShortName();

        return strtoupper($action . '_' . $name);
    }

}