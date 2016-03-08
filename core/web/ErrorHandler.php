<?php

namespace luya\web;

class ErrorHandler extends \yii\web\ErrorHandler
{
    public $memoryReserveSize = 0;

    use \luya\traits\ErrorHandler;
}
