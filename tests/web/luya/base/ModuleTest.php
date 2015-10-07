<?php

namespace tests\web\luya\base;

use Yii;

class ModuleTest extends \tests\web\Base
{
    public function testImportMethod()
    {
        $module = Yii::$app->getModule('admin');

        $exec = new \luya\commands\ImportController('id', $module);
        $e = $module->import($exec);
    }
    
    public function testResolveRoute()
    {
        $module = Yii::$app->getModule('admin');
        
        $this->assertEquals('default', $module->resolveRoute(''));
        $this->assertEquals('default', $module->resolveRoute('admin'));
        $this->assertEquals('default', $module->resolveRoute('admin/default'));
        $this->assertEquals('default/index', $module->resolveRoute('admin/default/index'));
        $this->assertEquals('other', $module->resolveRoute('admin/other'));
        $this->assertEquals('other/index', $module->resolveRoute('admin/other/index'));
        
        $this->assertEquals('cms', $module->resolveRoute('cms'));
        $this->assertEquals('cms/default', $module->resolveRoute('cms/default'));
        $this->assertEquals('cms/default/index', $module->resolveRoute('cms/default/index'));
    }
}
