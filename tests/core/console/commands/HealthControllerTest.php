<?php

namespace luyatests\core\console\commands;

use Yii;
use luya\console\commands\HealthController;

class HealthControllerTest extends \luyatests\LuyaConsoleTestCase
{
    public function testActionIndex()
    {
        $ctrl = new HealthController('ctrl', Yii::$app);
        $ctrl->actionIndex();
    }
}
