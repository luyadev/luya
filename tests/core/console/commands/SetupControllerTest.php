<?php

namespace luyatests\core\console\commands;

use Yii;
use luya\console\commands\SetupController;
use luyatests\LuyaConsoleTestCase;

class SetupControllerTest extends LuyaConsoleTestCase
{
    public function testIndexAction()
    {
        $ctrl = new SetupController('setup', Yii::$app);
    }
}