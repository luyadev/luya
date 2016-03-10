<?php

namespace tests\web\cms\controllers;


use Yii;
use luyatest\LuyaWebTestCase;

class BlockControllerTest extends LuyaWebTestCase
{
    
    /**
     * callback and id is missng
     * @expectedException yii\web\BadRequestHttpException
     */
    public function testMissingItemId()
    {
        $response = Yii::$app->getModule('cms')->runAction('block/index');
    }
    
    /**
     * @expectedException yii\base\Exception
     */
    public function testUnableToFindItemId()
    {
        $response = Yii::$app->getModule('cms')->runAction('block/index', ['callback' => 'test', 'id' => 0]);
    }
}