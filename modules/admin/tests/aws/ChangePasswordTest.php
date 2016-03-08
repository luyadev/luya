<?php

namespace tests\web\admin\aws;

use Yii;

class ChangePasswordTest extends \tests\web\Base
{
    public $aws = null;

    public function setUp()
    {
        parent::setUp();
        $this->aws = Yii::createObject(['class' => 'admin\aws\ChangePassword', 'className' => 'admin\models\User']);
    }

    public function testIndex()
    {
        $this->assertNotEmpty($this->aws->index());
    }

    public function testErrorCallback()
    {
        $this->aws->setItemId(1);
        $response = $this->aws->callbackSave('foo', 'bar');
        $this->assertEquals(3, count($response));
        $this->assertEquals(1, $response['error']);
    }

    public function testSuccessCallback()
    {
        $this->aws->setItemId(1);
        $response = $this->aws->callbackSave('testluyaio', 'testluyaio');
        $this->assertEquals(3, count($response));
        $this->assertEquals(0, $response['error']);
    }
}
