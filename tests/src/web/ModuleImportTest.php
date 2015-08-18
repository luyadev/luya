<?php

namespace tests\src\web;

use Yii;

class ModuleImportTest extends \tests\BaseWebTest
{
    public function testAdminImport()
    {
        $module = Yii::$app->getModule('admin');
        
        $exec = new \luya\commands\ExecutableController('id', $module);
        $e = $module->import($exec);
        
        $this->assertArrayHasKey('filters', $e);
    }
}