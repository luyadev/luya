<?php

namespace luyatests\core\web;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\web\ErrorHandler;
use yii\web\NotFoundHttpException;
use luya\Exception;

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
        
        
        
        $this->assertContains('Whoops', Yii::$app->response->data);
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
    
    /**
     * @runInSeparateProcess
     */
    public function testTransferWithTransferableException()
    {
        Yii::$app->response->data = null;
        $handler = new ErrorHandler();
        $handler->transferException = true;
        
        $exception = new Exception("Transfer Me Not");
        ob_start();
        $handler->renderException($exception);
        ob_end_clean();
        
        // This exception will call a not resolvable url
        $this->assertNotNull($handler->lastTransferCall);
    }
}
