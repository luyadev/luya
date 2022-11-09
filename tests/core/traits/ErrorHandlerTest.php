<?php

namespace luyatests\core\traits;

use luya\console\ErrorHandler;
use luya\Exception;
use luya\exceptions\WhitelistedException;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Application;
use yii\web\NotFoundHttpException;

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
            $this->assertTrue(is_array($response['trace']));
        } catch (Exception $e) {
            $this->assertEquals('Error: foobar', $e->getMessage());
        }
    }

    public function testExceptionStringTrace()
    {
        try {
            $stud = new ErrorHandler();
            $response = $stud->getExceptionArray('Is a string exception');

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
            $this->assertTrue(is_array($response['trace']));
        } catch (Exception $e) {
            $this->assertEquals('Error: foobar', $e->getMessage());
        }
    }

    public function testExceptionArrayTrace()
    {
        try {
            $stud = new ErrorHandler();
            $response = $stud->getExceptionArray(['array', 'is', 'exception']);

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
            $this->assertTrue(is_array($response['trace']));
        } catch (Exception $e) {
            $this->assertEquals('Error: foobar', $e->getMessage());
        }
    }

    public function testBodyParams()
    {
        $stud = new ErrorHandler();
        $response = $stud->getExceptionArray(['array', 'is', 'exception']);

        $this->assertTrue(Yii::$app instanceof Application);
        $this->assertSame([], $response['bodyParams']);
    }

    public function testIsWhitelisted()
    {
        $stud = new ErrorHandler();
        $notFound = new NotFoundHttpException("not found");
        $this->assertTrue($stud->isExceptionWhitelisted($notFound));
        $this->assertFalse($stud->isExceptionWhitelisted(['foobar']));
        $other = new InvalidConfigException('invalid config');
        $this->assertFalse($stud->isExceptionWhitelisted($other));
        $whitelisted = new WhitelistedException('whitelisted!');
        $this->assertTrue($stud->isExceptionWhitelisted($whitelisted));
    }

    /*
    public function testTrace()
    {
        $ex = new Exception('foobar here');
        $stud = new ErrorHandler();
        $context = $stud->getExceptionArray($ex)['trace'][0];

        $this->assertStringContainsString('new Exception(\'foobar here\')', $context['context_line']);
    }
    */
}
