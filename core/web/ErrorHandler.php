<?php

namespace luya\web;

/**
 * LUYA ErrorHandler wrapper with error handler trait
 *
 * @author nadar
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    public $memoryReserveSize = 0;

    use \luya\traits\ErrorHandler;
}
