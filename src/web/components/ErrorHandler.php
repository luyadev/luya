<?php

namespace luya\web\components;

class ErrorHandler extends \yii\web\ErrorHandler
{
    public $memoryReserveSize = 0;
   
    use \luya\traits\ErrorHandler;
}
