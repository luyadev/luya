<?php

namespace tests\web\luya\helpers;

use Yii;
use luya\helpers\Url;

class UrlTest extends \tests\web\Base
{
    public function testFromRoute()
    {
        $return = Url::fromRoute('module/controller/action');
        $this->assertEquals(true, is_array($return));
        $return = Url::fromRoute('module/controller');
        $this->assertEquals(false, $return);
    }

    public function testTrailing()
    {
        $this->assertEquals('foo/', Url::trailing('foo'));
    }

    public function testRemoveTrailing()
    {
        $this->assertEquals('foo', Url::removeTrailing('foo//'));
    }

    public function testToModule()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = Url::toModule(1, 'news/default/detail', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/page-1/news/1/foo-bar', $url);
    }

    public function testToAjax()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = Url::toAjax('news/default/index', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/news/default/index?id=1&title=foo-bar', $url);
    }
}
