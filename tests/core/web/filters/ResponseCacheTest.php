<?php

namespace luyatests\core\web\filters;

use luya\web\Controller;
use luya\web\filters\ResponseCache;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\base\Action;

class StubAction extends Action
{
    public function run()
    {
        return 'foobar';
    }
}

class StubBehaviorController extends Controller
{
    public function behaviors()
    {
        return [
            'rspcache' => [
                'class' => ResponseCache::className(),
                'actions' => ['foobar'],
                'variations' => ['bar' => 'foo']
            ],
        ];
    }

    public function actionFoobar()
    {
        Yii::$app->response->content = 'FooBarContent';
        return 'FooBarContent';
    }
}

class StubController extends Controller
{
}

/* TESTS */

class ResponseCacheTest extends LuyaWebTestCase
{
    public function testNotInsideActionList()
    {
        $controller = new StubController('fooctrl', Yii::$app);
        $action = new StubAction('fooaction', $controller);

        $filter = new ResponseCache();
        $content = $filter->beforeAction($action);
        $this->assertTrue($content);
    }

    /*
    public function testInsideActionListAndExistsInCache()
    {
        Yii::$app->set('cache', ['class' => UnitCache::className(), 'data' => []]);

        $controller = new StubController('fooctrl', Yii::$app);
        $action = new StubAction('fooaction', $controller);

        //Yii::$app->response->isSent = true; // mark response as sent, otherwise the unit test would output "foobar" as the caching behavior sends the content!

        $filter = new ResponseCache(['actions' => ['fooaction']]);

        // whether the action should continue to be executed.
        $content = $filter->beforeAction($action);

        $controller->runAction('fooaction');


        $this->assertFalse(false);
        $this->assertSame('foobar', Yii::$app->response->content);

    }
    */

    public function testInsideActionListButNotInCache()
    {
        //Yii::$app->set('cache', ['class' => UnitCache::className(), 'data' => ['1c0df0a894101ab12bd0535c3dc11a11' => 'foobar']]);
        $controller = new StubController('fooctrl', Yii::$app);
        $action = new StubAction('fooaction', $controller);

        $filter = new ResponseCache();
        $content = $filter->beforeAction($action);
        $this->assertTrue($content);
    }

    /*
    public function testInsideActionListButNotInCacheButTriggerAfterSendEvent()
    {
        Yii::$app->set('cache', ['class' => UnitCache::className()]);
        $controller = new StubBehaviorController('fooctrl', Yii::$app);
        $controller->runAction('foobar');

        Yii::$app->response->trigger('afterSend');

        $this->assertSame('FooBarContent', Yii::$app->cache->data['032b8391b2fab93f9dca5e5cd08cbe9b']);
    }
    */
}
