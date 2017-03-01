<?php

namespace luya\web;

use yii\base\Event;

/**
 * ErrorHandler Exception Render Event.
 * 
 * This event will be trigger before the ErrorHandler starts to render the exception.
 * 
 * The $exception property contains the throwed {{yii\base\Exception}} object.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ErrorHandlerExceptionRenderEvent extends Event
{
    /**
     * @var \yii\base\Exception
     */
    public $exception;
}