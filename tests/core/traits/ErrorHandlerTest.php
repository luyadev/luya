<?php

namespace luyatests\core\traits;

use Exception;
use luyatests\LuyaWebTestCase;
use luya\console\ErrorHandler;

class ErrorHandlerTest extends LuyaWebTestCase
{
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