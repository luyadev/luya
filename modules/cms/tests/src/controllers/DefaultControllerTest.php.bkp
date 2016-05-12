<?php

namespace cmstests\src\controllers;

use cmstests\CmsFrontendTestCase;
use cms\Module;
use Yii;

class DefaultControllerTest extends CmsFrontendTestCase
{
    public function testDefaultPage()
    {
        $response = (new Module('cms'))->runAction('default/index');
        
        $this->assertFalse(empty($response));
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     * @backupGlobals enabled
     */
    public function testNotFoundPage()
    {
        $_GET['path'] = 'not/found';
        $response = Yii::$app->getModule('cms')->runAction('default/index');
    }
}
