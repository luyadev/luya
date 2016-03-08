<?php

namespace tests\web\cms\controllers;


use Yii;

class DefaultControllerTest extends \tests\web\Base
{
    public function testDefaultPage()
    {
        $response = Yii::$app->getModule('cms')->runAction('default/index');
        
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