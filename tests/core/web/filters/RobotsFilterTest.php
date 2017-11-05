<?php

namespace luyatests\core\web\filters;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\web\Controller;
use luya\web\filters\RobotsFilter;

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
    public function testRobotsFilter()
    {
        $ctrl = new StubRobotsController('stub', Yii::$app);
        $this->assertSame('foobar', $ctrl->runAction('test'));
    }
    
    public function testPostRequestRobotsFilter()
    {
        $_SERVER['REQUEST_METHOD'] = 'post';
        $ctrl = new StubRobotsController('stub', Yii::$app);
        $this->expectException('yii\base\InvalidCallException');
        $this->assertSame('foobar', $ctrl->runAction('test'));
    }
}
