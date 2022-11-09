<?php

namespace luyatests\core\console\commands;

use luya\console\commands\HealthController;
use luya\testsuite\traits\CommandStdStreamTrait;
use Yii;

class HealthControllerTest extends \luyatests\LuyaConsoleTestCase
{
    public function testActionIndex()
    {
        $ctrl = new HealthControllerStub('ctrl', Yii::$app);
        $ctrl->actionIndex();

        $this->assertEquals("The directory the health commands is applying to: " . realpath(Yii::getAlias('@luyatests/data')), $ctrl->readOutput());
        $this->assertEquals("public_html/assets: directory exists already", $ctrl->readOutput());
        $this->assertEquals("public_html/storage: successfully created directory", $ctrl->readOutput());
        $this->assertEquals("migrations: directory exists already", $ctrl->readOutput());
        $this->assertEquals("vendor: directory exists already", $ctrl->readOutput());
        $this->assertEquals("runtime: directory exists already", $ctrl->readOutput());
        $this->assertEquals("configs/env.php: file does not exists!", $ctrl->readOutput());
        $this->assertEquals("public_html/index.php: file does not exists!", $ctrl->readOutput());
        $this->assertEquals("Health check found errors!", $ctrl->readOutput());
    }
}

class HealthControllerStub extends HealthController
{
    use CommandStdStreamTrait;
}
