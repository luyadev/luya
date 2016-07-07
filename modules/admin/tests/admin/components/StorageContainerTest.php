<?php

namespace admintests\components;

use Yii;
use admintests\AdminTestCase;

class StorageContainerTest extends AdminTestCase
{
    public function testHttpPath()
    {
        $this->assertEquals('/luya/envs/dev/public_html/storage', Yii::$app->storage->httpPath);
    }
    
    public function testAbsoluteHttpPath()
    {
        $this->assertEquals('http://localhost/luya/envs/dev/public_html/storage', Yii::$app->storage->absoluteHttpPath);
    }
    
    public function testServerPath()
    {
        $this->assertEquals('/var/www/luya/envs/dev/public_html/storage', Yii::$app->storage->serverPath);
    }
}
