<?php

namespace luyatests\core\web\filters;

use luya\web\Controller;
use luya\web\filters\RobotsFilter;
use luyatests\LuyaWebTestCase;
use Yii;

class StubRobotsController extends Controller
{
    public function behaviors()
    {
        return [
            'robotsFilter' => [
                'class' => RobotsFilter::class,
                'delay' => 0.5,
            ]
        ];
    }

    public function actionTest()
    {
        return 'foobar';
    }
}

class RobotsFilterTest extends LuyaWebTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testRobotsFilter()
    {
        $ctrl = new StubRobotsController('stub', Yii::$app);
        $this->assertSame('foobar', $ctrl->runAction('test'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testPostRequestRobotsFilter()
    {
        $_SERVER['REQUEST_METHOD'] = 'post';
        $ctrl = new StubRobotsController('stub', Yii::$app);
        $this->expectException('luya\exceptions\WhitelistedException');
        $this->assertSame('foobar', $ctrl->runAction('test'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testNewArrayBasedKeys()
    {
        $filter = new RobotsFilter();

        $this->assertSame('res', $filter->afterAction('xyz', 'res'));
        $this->assertTrue($filter->beforeAction('xyz'));

        $this->assertSame('generic', $this->invokeMethod($filter, 'getSessionKeyByOwner'));

        $this->assertSame(time(), $this->invokeMethod($filter, 'getRenderTime'));
    }
}
