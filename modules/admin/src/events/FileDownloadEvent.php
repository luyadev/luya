<?php

namespace luya\admin\events;

/**
 * File Download Event.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FileDownloadEvent extends \yii\base\Event
{
    public $isValid = true;
    
    public $file;
}
