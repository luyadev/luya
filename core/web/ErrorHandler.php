<?php

namespace luya\web;

use luya\traits\ErrorHandlerTrait;

/**
 * LUYA ErrorHandler wrapper with error handler trait
 *
 * @author nadar
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    use ErrorHandlerTrait;
}
