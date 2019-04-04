<?php

namespace luyatests\core\console;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\Exception;
use luya\console\ErrorHandler;

class ErrorHandlerTest extends LuyaConsoleTestCase
{
    public function testRenderConsoleException()
    {
        $error = new Exception('Random error');
        $handler = new ErrorHandler();
        $handler->transferException = true;
        ob_start();
        $handler->renderException($error);
        $output = ob_get_clean();
        
        $this->assertNotNull($handler->lastTransferCall);
    }
}
