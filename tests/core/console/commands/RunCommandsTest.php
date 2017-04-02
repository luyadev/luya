<?php

namespace luyatests\core\console\commands;

use Yii;

class RunCommandsTest extends \luyatests\LuyaConsoleTestCase
{
    public function testCustomCommandSuccess()
    {
        Yii::$app->request->setParams([
            'unitmodule/command-output/success',
        ]);

        $this->assertEquals(0, Yii::$app->run());
    }

    public function testCustomCommandError()
    {
        Yii::$app->request->setParams([
            'unitmodule/command-output/error',
        ]);

        $this->assertEquals(1, Yii::$app->run());
    }
}
