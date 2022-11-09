<?php

namespace luyatests\core\base;

use luyatests\data\modules\urlmodule\Module;
use luyatests\LuyaWebTestCase;
use Yii;

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

    public function testRequireComponentsException()
    {
        Yii::$app->getModule('unitmodule')->requiredComponents['foo'] = 'bar';
        $this->expectException('yii\base\InvalidConfigException');
        Yii::$app->getModule('unitmodule')->init();
    }

    public function testRegisterTranslation()
    {
        Module::registerTranslation('test*', '@luya/messages', ['luyua/test']);
        Module::registerTranslation('foo*', '@luya/foobar/message', ['foo' => 'foo.php']);

        $this->assertArrayHasKey('foo*', Yii::$app->i18n->translations);
        $this->assertArrayHasKey('test*', Yii::$app->i18n->translations);
    }

    public function testUseAppLayoutPath()
    {
        Yii::$app->getModule('unitmodule')->useAppLayoutPath = true;
        $p = Yii::$app->getModule('unitmodule')->getLayoutPath();
        $this->assertStringContainsString('views/unitmodule/layouts', $p);
    }

    public function testNotUseAppLayoutPath()
    {
        Yii::$app->getModule('unitmodule')->useAppLayoutPath = false;
        $p = Yii::$app->getModule('unitmodule')->getLayoutPath();
        $this->assertStringContainsString('unitmodule/views/layouts', $p);
    }

    public function testThemeLayoutPath()
    {
        Yii::$app->themeManager->activeThemeName = '@app/themes/moduleTest';
        Yii::$app->themeManager->setup();

        /** @var \luya\base\Module $module */
        $module = Yii::$app->getModule('unitmodule');
        $module->luyaBootstrap(Yii::$app);

        $module->useAppLayoutPath = false;
        $this->assertStringContainsString('/modules/unitmodule/views/layouts', $module->getLayoutPath());
    }

    public function testThemeUseAppLayoutPath()
    {
        Yii::$app->themeManager->activeThemeName = '@app/themes/moduleTest';
        Yii::$app->themeManager->setup();

        /** @var \luya\base\Module $module */
        $module = Yii::$app->getModule('unitmodule');
        $module->luyaBootstrap(Yii::$app);

        $module->useAppLayoutPath = true;
        $this->assertStringContainsString('/themes/moduleTest/views/layouts', $module->getLayoutPath());
    }

    public function testGetControllerFiles()
    {
        $f = Yii::$app->getModule('unitmodule')->getControllerFiles();
        $this->assertArrayHasKey('other', $f);
    }

    public function testUrlRulesSetterGetter()
    {
        $m = new Module('mod');

        $this->assertSame([
            ['pattern' => 'urlmodule/bar', 'route' => 'urlmodule/bar/index'],
            ['pattern' => 'urlmodule', 'route' => 'urlmodule/default/index'],
        ], $m->urlRules);

        $m->setUrlRules(['foo' => 'bar']);

        // accessing the virtual property will lead into accessing the original backwards compatibale
        // $urlRules property defined trough the module.
        $this->assertNotSame(['foo' => 'bar'], $m->urlRules);
        $this->assertSame(['foo' => 'bar'], $m->getUrlRules());
    }
}
