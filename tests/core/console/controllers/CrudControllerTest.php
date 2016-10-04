<?php

namespace luyatests\core\console\controllers;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\CrudController;

class CrudControllerTest extends LuyaConsoleTestCase
{
    public function testAssertsion()
    {
        $ctrl = new CrudController('id', Yii::$app);
        
        $testShema = Yii::$app->db->getTableSchema('admin_user', true);
        
        $this->assertSame(7, count($ctrl->generateRules($testShema)));
        $this->assertSame(13, count($ctrl->generateLabels($testShema)));
    }
}