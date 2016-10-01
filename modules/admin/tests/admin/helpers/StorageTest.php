<?php

namespace admintests\admin\helpers;

use admintests\AdminTestCase;
use luya\admin\helpers\Storage;

class StorageTest extends AdminTestCase
{
    public function testUploadFromFiles()
    {
        $_FILES[] = ['tmp_name' => \Yii::getAlias('@data/image.jpg'), 'name' => 'image.jpg', 'type' => 'image/jpg', 'error' => 0, 'size' => 123];
        
        $response = Storage::uploadFromFiles($_FILES);
        
        $this->assertFalse($response['upload']);
    }
}
