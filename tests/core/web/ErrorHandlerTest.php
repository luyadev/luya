<?php

namespace luyatests\core\web;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\web\ErrorHandler;
use yii\web\NotFoundHttpException;

class ErrorHandlerTest extends LuyaWebTestCase
{
    public function testTriggerException()
    {
        $handler = new ErrorHandler();
        $exception = new NotFoundHttpException("Whoops");
        
        ob_start();
        $handler->renderException($exception);
        ob_end_clean();
        
        $this->assertContains('Whoops', Yii::$app->response->data);
    }
}
