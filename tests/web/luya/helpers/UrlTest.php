<?php

namespace tests\web\luya\helpers;

use Yii;
use luya\helpers\Url;

class UrlTest extends \tests\web\Base
{

    public function testTrailing()
    {
        Yii::$app->composition->hidden = true;
        $this->assertEquals('foo/', Url::trailing('foo'));
    }

    public function testRemoveTrailing()
    {
        Yii::$app->composition->hidden = true;
        $this->assertEquals('foo', Url::removeTrailing('foo//'));
    }

    public function testToModule()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = \cms\helpers\Url::toMenuItem(1, 'news/default/detail', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/1/foo-bar', $url);
    }

    public function testToAjax()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = Url::toAjax('news/default/index', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/news/default/index?id=1&title=foo-bar', $url);
    }
    
    public function testBaseHelper()
    {
        $a = Url::toManager('urlmodule/bar/index');
        $this->assertEquals($a, Url::to(['/urlmodule/bar/index']));
        $this->assertEquals($a, Url::toRoute('/urlmodule/bar/index'));
        
        $b = Url::toManager('urlmodule/default/index');
        $this->assertEquals($b, Url::to(['/urlmodule/default/index']));
        $this->assertEquals($b, Url::toRoute('/urlmodule/default/index'));
        
        $c = Url::toManager('news/default/detail', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals($c, Url::to(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']));
        $this->assertEquals($c, Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']));
    }
}
