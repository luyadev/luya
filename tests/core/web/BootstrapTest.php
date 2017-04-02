<?php

namespace luyatests\core\web;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\web\Bootstrap;
use luya\TagParser;

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
}
