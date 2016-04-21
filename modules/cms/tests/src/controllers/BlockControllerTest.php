<?php

namespace cmstests\src\controllers;

use cmstests\CmsFrontendTestCase;
use cms\Module;

class BlockControllerTest extends CmsFrontendTestCase
{
    
    /**
     * callback and id is missng
     * @expectedException yii\web\BadRequestHttpException
     */
    public function testMissingItemId()
    {
        $response = (new Module('cms'))->runAction('block/index');
    }
    
    /**
     * @expectedException yii\base\Exception
     */
    public function testUnableToFindItemId()
    {
        $response = (new Module('cms'))->runAction('block/index', ['callback' => 'test', 'id' => 0]);
    }
}
