<?php

namespace luya\admin\events;

class FileDownloadEvent extends \yii\base\Event
{
    public $isValid = true;
    
    public $file = null;
}
