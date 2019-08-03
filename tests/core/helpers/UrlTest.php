<?php

namespace luyatests\core\helpers;

use Yii;
use luya\helpers\Url;

class UrlTest extends \luyatests\LuyaWebTestCase
{
    public function testTrailing()
    {
        Yii::$app->composition->hidden = true;
        $this->assertEquals('foo/', Url::trailing('foo'));
        $this->assertEquals('foo/', Url::trailing('foo/'));
        $this->assertEquals('foo/', Url::trailing('foo//'));
    }

    public function testToAjax()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = Url::toAjax('news/default/index', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('http://localhost/en/news/default/index?id=1&title=foo-bar', $url);
    }
    
    public function testBaseHelper()
    {
        $a = Url::toRoute(['/urlmodule/bar/index']);
        $this->assertEquals($a, Url::to(['/urlmodule/bar/index']));
        $this->assertEquals($a, Url::toRoute('/urlmodule/bar/index'));
        
        $b = Url::toRoute(['/urlmodule/default/index']);
        $this->assertEquals($b, Url::to(['/urlmodule/default/index']));
        $this->assertEquals($b, Url::toRoute('/urlmodule/default/index'));
        
        $c = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals($c, Url::to(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']));
        $this->assertEquals($c, Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']));
    }
    
    public function testAjaxStaticHelper()
    {
        Yii::$app->request->baseUrl = '';
        $this->assertEquals('http://localhost/en/not/exists/action', Url::toAjax('not/exists/action'));
        
        Yii::$app->composition->hidden = true;
        $this->assertEquals('http://localhost/not/exists/action', Url::toAjax('not/exists/action'));
    }
    
    public function testHelperEquals()
    {
        Yii::$app->composition->hidden = true;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toRoute(['/admin/login/index']));
        
        Yii::$app->composition->hidden = false;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toRoute(['/admin/login/index']));
        
        Yii::$app->composition->hidden = true;
        $this->assertEquals(Url::to(['/admin/login/index'], true), Url::toRoute(['/admin/login/index'], true));
        
        Yii::$app->composition->hidden = false;
        $this->assertEquals(Url::to(['/admin/login/index'], true), Url::toRoute(['/admin/login/index'], true));
    }
    
    public function testHelperEqualsInternal()
    {
        Yii::$app->composition->hidden = true;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toInternal(['admin/login/index']));
    
        Yii::$app->composition->hidden = false;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toInternal(['admin/login/index']));
        
        Yii::$app->composition->hidden = true;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toInternal(['admin/login/index']));
        
        Yii::$app->composition->hidden = false;
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toInternal(['admin/login/index']));
    }
    
    public function testHelperEqualsAbsoluteInternal()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        Yii::$app->composition->hidden = true;
        $this->assertEquals(Url::to(['/admin/login/index'], true), Url::toInternal(['admin/login/index'], true));
    
        Yii::$app->composition->hidden = false;
        $this->assertEquals(Url::to(['/admin/login/index'], true), Url::toInternal(['admin/login/index'], true));
    }
    
    public function testEnsureHttp()
    {
        $this->assertEquals('http://luya.io', Url::ensureHttp('luya.io'));
        $this->assertEquals('http://www.luya.io', Url::ensureHttp('www.luya.io'));
        $this->assertEquals('http://luya.io', Url::ensureHttp('http://luya.io'));
        $this->assertEquals('http://www.luya.io', Url::ensureHttp('http://www.luya.io'));
        $this->assertEquals('https://www.luya.io', Url::ensureHttp('https://www.luya.io'));
        
        
        $this->assertEquals('https://luya.io', Url::ensureHttp('luya.io', true));
        $this->assertEquals('https://www.luya.io', Url::ensureHttp('www.luya.io', true));
        $this->assertEquals('https://luya.io', Url::ensureHttp('https://luya.io', true));
        $this->assertEquals('https://www.luya.io', Url::ensureHttp('https://www.luya.io', true));
        
        $this->assertEquals('http://luya.io', Url::ensureHttp('http://luya.io', true)); // @TODO ensure https, expected: https://luya.io
    }

    public function testCleanHost()
    {
        $this->assertSame('luya.io/barfoo', Url::cleanHost('https://luya.io/barfoo'));
        $this->assertSame('luya.io/barfoo', Url::cleanHost('luya.io/barfoo'));
        $this->assertSame('luya.io/barfoo', Url::cleanHost('www.luya.io/barfoo'));
        $this->assertSame('luya.io/barfoo', Url::cleanHost('https://www.luya.io/barfoo'));
    }

    public function testDomain()
    {
        $this->assertSame('luya.io', Url::domain('https://luya.io/barfoo'));
        $this->assertSame('luya.io', Url::domain('luya.io/barfoo'));
        $this->assertSame('luya.io', Url::domain('www.luya.io/barfoo'));
        $this->assertSame('luya.io', Url::domain('https://www.luya.io/barfoo'));
    }
}
