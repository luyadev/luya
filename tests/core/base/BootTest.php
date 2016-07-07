<?php

namespace luyatests\core\base;

use luya\Boot;

class BootTest extends \luyatests\LuyaWebTestCase
{
    public function testBaseObject()
    {
        $boot = new Boot();
        $this->assertEquals('cli', $boot->getSapiName());
    }

    /**
     * @expectedException Exception
     */
    public function testUnableToFindConfigFile()
    {
        $boot = new Boot();
        $boot->run();
    }
    
    /**
     * @expectedException Exception
     */
    public function testWrongConfigFile()
    {
        $boot = new Boot();
        $boot->configFile = __DIR__ . '/../../data/configs/wrongconfig.php';
        $boot->run();
    }
    
    /**
     * @expectedException Exception
     */
    public function testYiiNotFound()
    {
        $boot = new Boot();
        $boot->configFile = __DIR__ . '/../../data/configs/console.php';
        $boot->setYiiPath('wrongPathToYii.php');
        $boot->mockOnly = true;
        $boot->applicationConsole();
    }
}
