<?php

namespace tests\src\cli;

use Yii;

class RunCommandsTest extends \tests\BaseCliTest
{   
    public function testCustomCommandSuccess()
    {
        
        Yii::$app->request->setParams([
            'command', 'moduletest', 'unit-test/success',
        ]);
        
        $this->assertEquals(1, Yii::$app->run());
    }
    
    public function testCustomCommandError()
    {
    
        Yii::$app->request->setParams([
            'command', 'moduletest', 'unit-test/error',
        ]);
    
        $this->assertEquals(0, Yii::$app->run());
    }
}