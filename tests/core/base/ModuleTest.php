<?php

namespace luyatests\core\base;

use Yii;
use luyatests\LuyaWebTestCase;

class ModuleTest extends LuyaWebTestCase
{

    public function testResolveRoute()
    {
        $module = Yii::$app->getModule('urlmodule');

        $this->assertEquals('default', $module->resolveRoute(''));
        $this->assertEquals('default', $module->resolveRoute('urlmodule'));
        $this->assertEquals('default', $module->resolveRoute('urlmodule/default'));
        $this->assertEquals('default/index', $module->resolveRoute('urlmodule/default/index'));
        $this->assertEquals('other', $module->resolveRoute('urlmodule/other'));
        $this->assertEquals('other/index', $module->resolveRoute('urlmodule/other/index'));

        $this->assertEquals('cms', $module->resolveRoute('cms'));
        $this->assertEquals('cms/default', $module->resolveRoute('cms/default'));
        $this->assertEquals('cms/default/index', $module->resolveRoute('cms/default/index'));
    }
    
    public function testGetControllerFiles()
    {
    	var_dump(Yii::$aliases);
    	$module = Yii::$app->getModule('urlmodule');
    
    	var_dump($module->getControllerPath());
    	exit;
    }
}
