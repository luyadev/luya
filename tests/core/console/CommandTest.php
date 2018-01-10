<?php

namespace luyatests\core\console;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\Command;

class SubCommand extends Command
{
    // as command is an abstract class
}


class CommandTest extends LuyaConsoleTestCase
{
    public function testModuleTypeSelector()
    {
        $cmd = new SubCommand('myid', Yii::$app->getModule('unitmodule'));
        
        $className = $cmd->createClassName('das-ist-mein', 'mein0r');
        
        $this->assertEquals('FooActiveWindow', $cmd->createClassName('FooActiveWindow', 'ActiveWindow'));
        $this->assertEquals('FooActiveWindow', $cmd->createClassName('foo-active-window', 'ActiveWindow'));
        $this->assertEquals('FooActiveWindow', $cmd->createClassName('foo', 'ActiveWindow'));
    }
    
    public function testHelper()
    {
        $cmd = new SubCommand('myid', Yii::$app->getModule('unitmodule'));
    }
}
