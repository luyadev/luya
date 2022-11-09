<?php

namespace luyatests\core\console;

use luya\console\Command;
use luyatests\LuyaConsoleTestCase;
use Yii;

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
        $help = $cmd->getHelp();
        $this->assertSame('', $help);
    }

    public function testPrintableDebugMessage()
    {
        $cmd = new SubCommand('myid', Yii::$app->getModule('unitmodule'));
        $this->assertSame('foobar', $cmd->printableMessage('foobar'));
        $this->assertSameTrimmed('array (
  \'foo\' => \'bar\',           
)', $cmd->printableMessage(['foo' => 'bar']));

        $cmd->verbose = 1;
        $cmd->verbosePrint('verbose!');

        $this->app->mute = 0;

        $this->assertSame(1, $cmd->outputError('test'));
        $this->assertSame(0, $cmd->outputSuccess(['foo' => 'bar']));
        $this->assertSame(0, $cmd->outputInfo('info'));
    }
}
