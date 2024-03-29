<?php

namespace luya\web;

use luya\traits\ErrorHandlerTrait;

/**
 * LUYA ErrorHandler wrapper with error handler trait
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    use ErrorHandlerTrait {
        renderException as protected traitRenderException;
    }
    /**
     * @var string Event will be trigger before the ErrorHandler starts to render the exception.
     */
    public const EVENT_BEFORE_EXCEPTION_RENDER = 'onBeforeExceptionRender';

    /**
     * @inheritdoc
     */
    public function renderException($exception)
    {
        $event = new ErrorHandlerExceptionRenderEvent();
        $event->exception = $exception;
        $this->trigger(self::EVENT_BEFORE_EXCEPTION_RENDER, $event);

        return $this->traitRenderException($exception);
    }
}
