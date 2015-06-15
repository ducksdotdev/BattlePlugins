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
                (new Webhooks)->triggerWebhook($model, $model->getActivityName($model, $event));
            });
        }
    }

    protected function getModelEvents()
    {
        if (isset(static::$webhookEvents))
            return static::$webhookEvents;

        return ['created', 'deleted', 'updated'];
    }

    protected function getActivityName($model, $action)
    {
        $name = (new ReflectionClass($model))->getShortName();

        return strtoupper($action . '_' . $name);
    }

}