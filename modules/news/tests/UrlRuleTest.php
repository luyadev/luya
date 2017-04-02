<?php

namespace tests\web\news;

use Yii;
use luya\helpers\Url;

class UrlRuleTest extends \tests\web\Base
{
    public $urlRules = [
        ['pattern' => 'news/detail/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
        ['pattern' => 'news/global-test/<id:\d+>/', 'route' => 'news/test', 'composition' => [
                'fr' => 'news/french-test/<id:\d+>/',
                'en' => 'news/english-test/<id:\d+>/',
                'de' => 'news/deutsch-test/<id:\d+>/',
            ],
        ],
    ];

    public function setUp()
    {
        parent::setUp();
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        Yii::$app->urlManager->addRules($this->urlRules);
        Yii::$app->composition->setKey('langShortCode', 'en');
    }

    public function testComposition()
    {
        Yii::$app->composition->hidden = true;
        $full = Yii::$app->composition->getFull();
        $this->assertEquals('', $full);

        Yii::$app->composition->hidden = false;
        $full = Yii::$app->composition->getFull();
        $this->assertEquals('en', $full);
    }

    public function testCompositionUrls()
    {
        Yii::$app->composition->hidden = false;
        // fr
        Yii::$app->composition->setKey('langShortCode', 'fr');
        $this->assertEquals('/fr/news/french-test/1', Url::toRoute(['/news/test', 'id' => 1]));
        // en
        Yii::$app->composition->setKey('langShortCode', 'en');
        $this->assertEquals('/en/news/english-test/1', Url::toRoute(['/news/test', 'id' => 1]));
        // de
        Yii::$app->composition->setKey('langShortCode', 'de');
        $this->assertEquals('/de/news/deutsch-test/1', Url::toRoute(['/news/test', 'id' => 1]));
        // ru (composition not set, use global default pattern)
        Yii::$app->composition->setKey('langShortCode', 'ru');
        $this->assertEquals('/ru/news/global-test/1', Url::toRoute(['/news/test', 'id' => 1]));

        // composition is hidden, so url rules automaticcaly retursn generic default global pattern
        Yii::$app->composition->hidden = true;
        // fr (will not work cause hidden)
        Yii::$app->composition->setKey('langShortCode', 'fr');
        $this->assertEquals('/news/global-test/1', Url::toRoute(['/news/test', 'id' => 1]));
    }

    public function testBasicUrls()
    {
        Yii::$app->composition->hidden = true;
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/news/1/foo-bar', $url);

        Yii::$app->composition->hidden = false;
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/en/news/1/foo-bar', $url);

        Yii::$app->composition->hidden = true;
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar', 'pa' => 'ram']);
        $this->assertEquals('/news/1/foo-bar?pa=ram', $url);

        Yii::$app->composition->hidden = false;
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar', 'pa' => 'ram']);
        $this->assertEquals('/en/news/1/foo-bar?pa=ram', $url);
    }

    public function testModuleContextUrls()
    {
        Yii::$app->urlManager->contextNavItemId = 1;

        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/1/foo-bar', $url);

        Yii::$app->urlManager->contextNavItemId = 2;

        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/en/page-1/1/foo-bar', $url);

        Yii::$app->urlManager->contextNavItemId = 2;

        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar', 'pa' => 'ram']);
        $this->assertEquals('/en/page-1/1/foo-bar?pa=ram', $url);

        Yii::$app->urlManager->contextNavItemId = 1;

        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'page-2-news-title', 'news' => 'page']);
        $this->assertEquals('/1/page-2-news-title?news=page', $url);
    }
    
    public function testModuleContextOtherModuleUrls()
    {
        Yii::$app->urlManager->contextNavItemId = 11;
    
        $this->assertEquals('/en/admin/login', Url::toRoute(['/admin/login/index']));
        $this->assertEquals('/en/admin/login', Url::to(['/admin/login/index']));
        $this->assertEquals('/en/admin/login', Url::toRoute(['/admin/login/index']));
        $this->assertEquals('/en/admin/login', Url::toInternal(['/admin/login/index']));
    }
    
    public function testModuleContextOtherModuleAbsoluteUrls()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        
        Yii::$app->urlManager->contextNavItemId = 11;
    
        $this->assertEquals('http://localhost/en/admin/login', Url::toRoute(['/admin/login/index'], true));
        $this->assertEquals('http://localhost/en/admin/login', Url::to(['/admin/login/index'], true));
        $this->assertEquals('http://localhost/en/admin/login', Url::toRoute(['/admin/login/index'], true));
        $this->assertEquals('http://localhost/en/admin/login', Url::toInternal(['/admin/login/index'], true));
        
        Yii::$app->urlManager->contextNavItemId = 1;
        
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar'], true);
        $this->assertEquals('http://localhost/1/foo-bar', $url);
        
        Yii::$app->urlManager->contextNavItemId = 2;
        
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar'], true);
        $this->assertEquals('http://localhost/en/page-1/1/foo-bar', $url);
        
        Yii::$app->urlManager->contextNavItemId = 2;
        
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'foo-bar', 'pa' => 'ram'], true);
        $this->assertEquals('http://localhost/en/page-1/1/foo-bar?pa=ram', $url);
        
        Yii::$app->urlManager->contextNavItemId = 1;
        
        $url = Url::toRoute(['/news/default/detail', 'id' => 1, 'title' => 'page-2-news-title', 'news' => 'page'], true);
        $this->assertEquals('http://localhost/1/page-2-news-title?news=page', $url);
    }
}
