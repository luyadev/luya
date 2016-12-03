<?php

namespace luya\web;

use luya\traits\ErrorHandlerTrait;

/**
 * LUYA ErrorHandler wrapper with error handler trait
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    use ErrorHandlerTrait;
}
