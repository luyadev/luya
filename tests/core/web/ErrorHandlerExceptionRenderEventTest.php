<?php

namespace luyatests\core\web;

use luya\web\ErrorHandlerExceptionRenderEvent;
use luyatests\LuyaWebTestCase;

class ErrorHandlerExceptionRenderEventTest extends LuyaWebTestCase
{
    public function testTriggerException()
    {
        $event = new ErrorHandlerExceptionRenderEvent();
        $event->exception = new \Exception('Exception');

        $this->assertInstanceOf('\Exception', $event->exception);
    }
}
