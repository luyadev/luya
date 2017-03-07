<?php

namespace luyatests\core\console;

use luyatests\LuyaConsoleTestCase;

use Yii;
use yii\console\Controller;

class ApplicationTest extends LuyaConsoleTestCase
{
    public function testInvalidCommandException()
    {
        $this->expectException('yii\console\Exception');
        Yii::$app->runAction('luya/luya/luya');
    }
    
    public function testInvalidRouteCommand()
    {
        $this->expectException('yii\console\Exception');
        Yii::$app->runAction('consolemodule/test-command/notavailable');
    }
        
    public function testRouting()
    {
        $this->assertSame(Controller::EXIT_CODE_NORMAL, Yii::$app->runAction('consolemodule/test-command/success'));
        $this->assertSame(Controller::EXIT_CODE_ERROR, Yii::$app->runAction('consolemodule/test-command/error'));
        $this->assertSame(Controller::EXIT_CODE_NORMAL, Yii::$app->runAction('consolemodule/test-command/info'));
    }
}
