<?php

namespace luya\console;

use luya\traits\ErrorHandlerTrait;

/**
 * Luya CLI ErrorHandler.
 *
 * @author nadar
 */
class ErrorHandler extends \yii\console\ErrorHandler
{
    use ErrorHandlerTrait;
    
    /**
     * @var streing This propertie has been added in order to make sure console commands config
     * does also work in console env.
     */
    public $errorAction = null;
}
