<?php

namespace luyatests\core\web;

use luya\TagParser;
use luya\web\Bootstrap;
use luyatests\LuyaWebTestCase;
use Yii;

class BootstrapTest extends LuyaWebTestCase
{
    public function testAdminModuleInit()
    {
        Yii::$app->tags = ['foobar' => ['class' => 'luya\tag\tags\TelTag']];

        Yii::$app->setModules(['admin' => ['class' => 'luyatests\data\modules\UnitAdminModule']]);
        Yii::$app->request->forceWebRequest = true;
        Yii::$app->request->setIsConsoleRequest(false);
        Yii::$app->request->isAdmin = true;

        $boot = new Bootstrap();
        $boot->bootstrap(Yii::$app);
        $boot->beforeRun(Yii::$app);
        $boot->run(Yii::$app);

        $this->assertFalse(Yii::$app->request->getIsConsoleRequest());
        $this->assertTrue(Yii::$app->request->isAdmin);
        $this->assertTrue($boot->hasModule('admin'));

        $this->assertArrayHasKey('foobar', TagParser::getInstantiatedTagObjects());
    }

    public function testThemeManagerSetup()
    {
        Yii::$app->request->forceWebRequest = true;
        Yii::$app->request->setIsConsoleRequest(false);
        Yii::$app->themeManager->activeThemeName = '@app/themes/blank';

        $boot = new Bootstrap();
        $boot->bootstrap(Yii::$app);

        $this->assertTrue(Yii::$app->themeManager->hasActiveTheme);
        $this->assertEquals('theme', Yii::$app->layout);
    }
}
