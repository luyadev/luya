<?php

namespace luyatests\core\web;

use luya\Exception;
use luya\web\ErrorHandler;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\web\NotFoundHttpException;

class ErrorHandlerTest extends LuyaWebTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testTriggerException()
    {
        $handler = new ErrorHandler();
        $exception = new NotFoundHttpException("Whoops");

        ob_start();
        $handler->renderException($exception);
        ob_end_clean();

        $this->assertStringContainsString('Whoops', Yii::$app->response->data);
    }

    /**
     * @runInSeparateProcess
     */
    public function testTransferWebException()
    {
        Yii::$app->response->data = null;
        $handler = new ErrorHandler();
        $handler->transferException = true;

        $exception = new NotFoundHttpException("Transfer Me Not");
        ob_start();
        $handler->renderException($exception);
        ob_end_clean();

        // NotFoundHttpException is in whitelist by default
        $this->assertNull($handler->lastTransferCall);
    }

    public function testTransferWithTransferableException()
    {
        $handler = new ErrorHandler();
        $exception = new Exception("Transfer Me Not");
        $arr = $handler->getExceptionArray($exception);

        $this->assertArrayHasKey('exception_name', $arr);
        $this->assertArrayHasKey('php_version', $arr);
        $this->assertArrayHasKey('luya_version', $arr);
        $this->assertArrayHasKey('status_code', $arr);
        $this->assertArrayHasKey('yii_env', $arr);
        $this->assertArrayHasKey('yii_debug', $arr);
        $this->assertArrayHasKey('exception_class_name', $arr);
    }
}
