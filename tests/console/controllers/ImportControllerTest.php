<?php

namespace tests\console\controllers;

use Yii;

class ImportControllerTest extends \tests\console\Base
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
