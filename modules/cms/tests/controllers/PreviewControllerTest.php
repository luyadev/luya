<?php

namespace tests\web\cms\controllers;


use Yii;

class PreviewControllerTest extends \tests\web\Base
{
    
    /**
     * itemId param is missing
     * @expectedException yii\web\BadRequestHttpException
     */
    public function testMissingItemId()
    {
        $response = Yii::$app->getModule('cms')->runAction('preview/index');
    }
    
    /**
     * itemId param is missing
     * @expectedException yii\web\ForbiddenHttpException
     */
    public function testNoAuthToView()
    {
        $response = Yii::$app->getModule('cms')->runAction('preview/index', ['itemId' => 1]);
    }
}