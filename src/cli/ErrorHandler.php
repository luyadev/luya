<?php

namespace luya\cli;

/**
 * Luya CLI ErrorHandler.
 * 
 * @author nadar
 */
class ErrorHandler extends \yii\console\ErrorHandler
{
    use \luya\traits\ErrorHandler;
}
