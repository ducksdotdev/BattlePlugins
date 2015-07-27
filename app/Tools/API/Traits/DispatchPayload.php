<?php

namespace App\Tools\API\Traits;

use App\Tools\Webhooks\Webhooks;
use Illuminate\Support\Facades\Config;
use ReflectionClass;

/**
 * Class DispatchPayload
 * @package App\Tools\API\Traits
 */
trait DispatchPayload {

    protected static function bootDispatchPayload() {
        foreach (static::getDispatchModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                (new Webhooks)->triggerWebhook($model, $model->getDispatchActivityName($event));
            });
        }
    }

    /**
     * @return mixed
     */
    protected static function getDispatchModelEvents() {
        return isset(static::$webhookEvents) ? static::$webhookEvents : Config::get('api.webhook_methods');
    }

    /**
     * @param $action
     * @return string
     */
    protected function getDispatchActivityName($action) {
        $name = (new ReflectionClass($this))->getShortName();

        return strtoupper($name . '_' . $action);
    }

}