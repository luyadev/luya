<?php

namespace luyatests\core\web;

use Yii;

class StubController extends \luya\web\Controller
{
}

class ControllerTest extends \luyatests\LuyaWebTestCase
{
    public $controller;

    public function afterSetup()
    {
        parent::afterSetup();
        $this->controller = new StubController('stub', Yii::$app->getModule('viewmodule'));
    }

    public function testViewRender()
    {
        $view1 = $this->controller->render('view1');
        $this->assertEquals('view1', $view1);
    }

    public function testViewLayoutRender()
    {
        $view2 = $this->controller->renderLayout('view2');
        $this->assertEquals('view2', $view2);
    }

    public function testViewLayoutRenderWithAliasPath()
    {
        $view3 = $this->controller->renderLayout('@viewmodule/views/stub/view2');

        $this->assertSame('view2', $view3);
    }
}
