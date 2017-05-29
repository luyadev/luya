<?php

namespace tests\admin\aws;

use Yii;
use admintests\AdminTestCase;

class ChangePasswordActiveWindowTest extends AdminTestCase
{
    public $aws;

    public function setUp()
    {
        parent::setUp();
        $this->aws = Yii::createObject(['class' => 'luya\admin\aws\ChangePasswordActiveWindow']);
    }

    public function testIndex()
    {
        $this->assertNotEmpty($this->aws->index());
    }

    /*
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
    */
}
