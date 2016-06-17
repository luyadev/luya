<?php

namespace luyatests\core\console;

use Yii;
use luya\console\Controller;
use luyatests\LuyaConsoleTestCase;

class TestController extends Controller
{
    
}

class ControllerTest extends LuyaConsoleTestCase
{
    public function testOutput()
    {
        $obj = new TestController('id', Yii::$app);
        $this->assertEquals(0, $obj->outputInfo('info'));
        $this->assertEquals(0, $obj->outputSuccess('success'));
        $this->assertEquals(1, $obj->outputError('error'));
    }
}