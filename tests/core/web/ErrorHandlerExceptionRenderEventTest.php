<?php

namespace luyatests\core\web;

use luyatests\LuyaWebTestCase;
use luya\web\ErrorHandlerExceptionRenderEvent;

class ErrorHandlerExceptionRenderEventTest extends LuyaWebTestCase
{
	public function testTriggerException()
	{
		$event = new ErrorHandlerExceptionRenderEvent();
		$event->exception = new \Exception('Exception');

		$this->assertInstanceOf('\Exception', $event->exception);
	}
}