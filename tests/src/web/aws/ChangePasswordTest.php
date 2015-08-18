<?php

namespace tests\src\web\aws;

class ChangePasswordTest extends \tests\BaseWebTest
{
    public $aws = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->aws = new \admin\aws\ChangePassword();
    }
    
    public function testIndex()
    {
        $this->assertNotEmpty($this->aws->index());
    }
    
    public function testErrorCallback()
    {
        $this->aws->setItemId(1);
        $response = $this->aws->callbackSave('foo', 'bar');
        $this->assertEquals(2, count($response));
        $this->assertEquals(1, $response['error']);
    }
    
    public function testSuccessCallback()
    {
        $this->aws->setItemId(1);
        $response = $this->aws->callbackSave('newpassword', 'newpassword');
        $this->assertEquals(2, count($response));
        $this->assertEquals(0, $response['error']);
    }
}