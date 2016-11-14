<?php

namespace admintests\admin\helpers;

use Yii;
use admintests\AdminTestCase;
use luya\admin\helpers\Storage;

class StorageTest extends AdminTestCase
{
    /*
    public function testSuccessUploadFromFiles()
    {
        $files[] = ['tmp_name' => Yii::getAlias('@data/image.jpg'), 'name' => 'image.jpg', 'type' => 'image/jpg', 'error' => 0, 'size' => 123];
        
        $response = Storage::uploadFromFiles($files);
        
        $this->assertTrue($response['upload']);
    }
    */
    
    public function testErrorUploadFromFiles()
    {
        $files[] = ['tmp_name' => 'not/found.jpg', 'name' => 'image.jpg', 'type' => 'image/jpg', 'error' => 1, 'size' => 123];
    
        $response = Storage::uploadFromFiles($files);
    
       $this->assertFalse($response['upload']);
    
    }
}
