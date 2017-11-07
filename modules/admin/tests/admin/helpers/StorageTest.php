<?php

namespace admintests\admin\helpers;

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
    
    public function testGetImageResolution()
    {
        $res = Storage::getImageResolution(__DIR__ . '/../../data/image.jpg');
        
        $this->assertSame(['width' => 2560, 'height' => 1600], $res);
    }
    
    public function testUploadErrorMessages()
    {
        $this->assertSame('The uploaded file exceeds the upload_max_filesize directive in php.ini.', Storage::getUploadErrorMessage(UPLOAD_ERR_INI_SIZE));
    }
}
