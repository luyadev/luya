<?php

namespace tests\web\admin\components;

use admin\components\Auth;

class AuthTest extends \tests\web\Base
{
    public $auth;
    
    public function setUp()
    {
        parent::setUp();

        $this->auth = new Auth();
        
    }
    
    public function testAddRoute()
    {
        $beforeData = $this->auth->getDatabaseAuths();
        
        $response = $this->auth->addRoute('foo', 'routename', 'baz');
        
        $this->assertEquals(1, $response);
        
        $response = $this->auth->addRoute('foo2', 'routename', 'baz2');
        
        $this->assertEquals(1, $response);
        
        $addApi = $this->auth->addApi('foo3', 'apiname', 'baz3');
        
        $response = $this->auth->prepareCleanup($beforeData);
        
        $this->assertEquals(2, count($response));
        
        $this->assertEquals('baz3', $response[0]['alias_name']);
        $this->assertEquals('baz2', $response[1]['alias_name']);
        
        $exec = $this->auth->executeCleanup($response);
        
        $this->assertEquals(true, $exec);
    }
}