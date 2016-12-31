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
    use ErrorHandlerTrait;
}
