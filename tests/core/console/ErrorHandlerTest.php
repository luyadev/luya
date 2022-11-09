<?php

namespace luyatests\core\console;

use luya\console\ErrorHandler;
use luya\Exception;
use luyatests\LuyaConsoleTestCase;

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
