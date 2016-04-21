<?php

namespace cmstests\src\controllers;

use Yii;
use cmstests\CmsFrontendTestCase;

class PreviewControllerTest extends CmsFrontendTestCase
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
