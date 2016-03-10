<?php

namespace tests\core\traits;

use Exception;
use tests\LuyaWebTestCase;
use luya\console\ErrorHandler;

class ErrorHandlerTest extends LuyaWebTestCase
{
    public function testRenderException()
    {
        $stud = new ErrorHandler();
        try {
            $e = $stud->renderException(new Exception('foobar'));
        } catch (Exception $err) {
            $this->assertEquals('Error: foobar', $err->getMessage());
        }
    }

    public function testExceptionTrace()
    {
        
        try {
        $stud = new ErrorHandler();
        $response = $stud->getExceptionArray(new Exception('foobar'));
        
        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('file', $response);
        $this->assertArrayHasKey('line', $response);
        $this->assertArrayHasKey('requestUri', $response);
        $this->assertArrayHasKey('serverName', $response);
        $this->assertArrayHasKey('date', $response);
        $this->assertArrayHasKey('trace', $response);
        $this->assertArrayHasKey('ip', $response);
        $this->assertArrayHasKey('get', $response);
        $this->assertArrayHasKey('post', $response);
        $this->assertTrue(is_Array($response['trace']));
        } catch(Exception $e) {
            $this->assertEquals('Error: foobar', $err->getMessage());
        }
    }
}