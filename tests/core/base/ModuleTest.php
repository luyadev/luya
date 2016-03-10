<?php

namespace luyatest\core\base;

use Yii;

class ModuleTest extends \luyatest\LuyaWebTestCase
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
}