<?php

namespace tests\web\luya\base;

use Yii;

class ModuleTest extends \tests\web\Base
{
    public function testImportMethod()
    {
        $module = Yii::$app->getModule('admin');
        
        $exec = new \luya\commands\ExecutableController('id', $module);
        $e = $module->import($exec);
        
        $this->assertArrayHasKey('filters', $e);
    }
}