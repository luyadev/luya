<?php

namespace luyatests\core\console;

use luyatests\LuyaConsoleTestCase;

use Yii;
use yii\console\Controller;
use luyatests\data\commands\TestConsoleCommand;
use luya\web\Application;

class ApplicationTest extends LuyaConsoleTestCase
{
    public function testInvalidCommandException()
    {
        $this->expectException('yii\console\Exception');
        $this->app->runAction('luya/luya/luya');
    }
    
    public function testInvalidRouteCommand()
    {
        $this->expectException('yii\console\UnknownCommandException');
        $this->app->runAction('consolemodule/test-command/notavailable');
    }

    public function testInvalidApplicationContext()
    {
        $module = new Application(['basePath' => dirname(__DIR__), 'id' => 'barfoo']);
        $this->expectException("yii\base\InvalidCallException");
        $command = new TestConsoleCommand('console', $module);
        $command->actionFoo();
    }
        
    public function testRouting()
    {
        $this->assertSame(Controller::EXIT_CODE_NORMAL, Yii::$app->runAction('consolemodule/test-command/success'));
        $this->assertSame(Controller::EXIT_CODE_ERROR, Yii::$app->runAction('consolemodule/test-command/error'));
        $this->assertSame(Controller::EXIT_CODE_NORMAL, Yii::$app->runAction('consolemodule/test-command/info'));
    }
}
