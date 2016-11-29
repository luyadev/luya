<?php

namespace luyatests\core\console\controllers;

use Yii;

class ImportControllerTest extends \luyatests\LuyaConsoleTestCase
{
    /*
    public function testCustomCommandSuccess()
    {
        Yii::$app->request->setParams([
            'exec/import',
        ]);

        $this->assertEquals(1, Yii::$app->run());

    }
    */

    public function testCustomCommandSuccess()
    {
        Yii::$app->request->setParams([
            'import/index',
        ]);

        $resp = Yii::$app->run();

        $this->assertEquals(0, $resp);
    }
}
