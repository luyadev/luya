<?php

namespace luyatests\core\web;

use luya\web\Composition;
use luya\web\Request;
use luya\web\UrlManager;
use luyatests\data\classes\UnitMenu;
use Yii;

class UrlStubController extends \luya\web\Controller
{
}

/**
 * @author nadar
 */
class UrlManagerTest extends \luyatests\LuyaWebTestCase
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

    public function afterSetup()
    {
        parent::afterSetup();
        Yii::$app->composition->setKey('langShortCode', 'en');
    }

    public function testBasicRequest()
    {
        $urlManager = new UrlManager();
        $urlManager->addRules($this->urlRules);

        $request = new Request();
        $request->pathInfo = 'news/detail/1/foo-bar';

        $r = $urlManager->parseRequest($request);

        $this->assertArrayHasKey(0, $r);
        $this->assertArrayHasKey(1, $r);

        $this->assertArrayHasKey('id', $r[1]);
        $this->assertArrayHasKey('title', $r[1]);

        $this->assertEquals('news/default/detail', $r[0]);

        $this->assertEquals('1', $r[1]['id']);
        $this->assertEquals('foo-bar', $r[1]['title']);
    }

    public function testRouteEqualCompositionParseRequest()
    {
        $urlManager = new UrlManager();

        $request = new Request();
        $request->pathInfo = 'en/en';

        $route = $urlManager->parseRequest($request);

        $this->assertSame('en', $route[0]);
    }

    public function testLtrimInsideParseRequest()
    {
        $string = '//test';
        $this->assertSame('test', ltrim($string, '/'));
        $string = '/test';
        $this->assertSame('test', ltrim($string, '/'));
        $string = '//';
        $this->assertSame('', ltrim($string, '/'));
        $string = '/';
        $this->assertSame('', ltrim($string, '/'));
    }

    public function testRequestWithTrailingSlashOnly()
    {
        $urlManager = new UrlManager();

        $request = new Request();
        $request->pathInfo = '/en////foobar//';

        $route = $urlManager->parseRequest($request);

        $this->assertSame('foobar', $route[0]);
    }

    public function testEnableStrictParsingRequest()
    {
        $urlManager = new UrlManager();
        $urlManager->enableStrictParsing = true;

        $request = new Request();
        $request->pathInfo = 'en/en';

        $route = $urlManager->parseRequest($request);

        $this->assertFalse($route);
    }

    public function testCompositionRequest()
    {
        $urlManager = new UrlManager();
        $urlManager->addRules($this->urlRules);

        $request = new Request();
        $request->pathInfo = 'news/english-test/1';

        $r = $urlManager->parseRequest($request);
        $this->assertArrayHasKey(0, $r);
        $this->assertArrayHasKey(1, $r);

        $this->assertArrayHasKey('id', $r[1]);

        $this->assertEquals('news/test', $r[0]);

        $this->assertEquals('1', $r[1]['id']);
    }

    public function testRequestComponent()
    {
        $request = new Request();
        $this->assertEquals(false, $request->isAdmin);

        $request = new Request();
        $request->forceWebRequest = true;
        $request->pathInfo = 'admin';
        $this->assertEquals(true, $request->isAdmin);

        $request = new Request();
        $request->forceWebRequest = true;
        $request->pathInfo = 'de/admin';
        $this->assertEquals(true, $request->isAdmin);

        $request = new Request();
        $request->forceWebRequest = true;
        $request->pathInfo = 'de/foo/admin';
        $this->assertEquals(false, $request->isAdmin);
    }

    public function testHiddenDefaultComposition()
    {
        Yii::$app->composition->hidden = true;

        $urlManager = new UrlManager();
        $request = new Request();
        $request->pathInfo = '';

        $r = $urlManager->parseRequest($request);

        $this->assertSame('', $r[0]);
        $this->assertEquals(0, count($r[1]));

        // not hidden

        Yii::$app->composition->hidden = false;

        $urlManager = new UrlManager();
        $request = new Request();
        $request->pathInfo = '';

        $r = $urlManager->parseRequest($request);

        $this->assertSame('', $r[0]);
        $this->assertEquals(0, count($r[1]));
    }

    public function testHiddenUrlCreation()
    {
        Yii::$app->composition->hidden = false;
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $urlManager = Yii::$app->urlManager;

        $this->assertSame('/en/urlmodule', $urlManager->createUrl(['urlmodule/default/index']));

        Yii::$app->composition->hidden = true;
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $this->assertSame('/urlmodule', $urlManager->createUrl(['urlmodule/default/index']));
    }

    public function testOriginalCreateAbsoluteUrl()
    {
        $urlManager = Yii::$app->urlManager;

        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';

        $this->assertEquals('http://localhost/en/urlmodule/bar', $urlManager->createAbsoluteUrl(['urlmodule/bar/index']));
        $this->assertEquals('http://localhost/en/module/not/found', $urlManager->createAbsoluteUrl(['module/not/found']));
        $this->assertEquals('http://localhost/en/urlmodule', $urlManager->createAbsoluteUrl(['urlmodule/default/index']));

        Yii::$app->composition->hidden = true;
        $this->assertEquals('http://localhost/urlmodule/bar', $urlManager->createAbsoluteUrl(['urlmodule/bar/index']));
        $this->assertEquals('http://localhost/module/not/found', $urlManager->createAbsoluteUrl(['module/not/found']));
        $this->assertEquals('http://localhost/urlmodule', $urlManager->createAbsoluteUrl(['urlmodule/default/index']));
    }

    public function testContextUrlCreationButMenuDoesNotExists()
    {
        $urlManager = Yii::$app->urlManager;
        $urlManager->contextNavItemId = 1;
        $this->assertEquals('/luya/envs/dev/public_html/en/urlmodule/bar', $urlManager->createUrl(['/urlmodule/bar/index']));
    }

    public function testCreateMenuItemUrl()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        Yii::$app->controller = new UrlStubController('stub', Yii::$app->getModule('unitmodule'));

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3);
        $this->assertSame('this-is-a-cms-link/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3, null, 'https');
        $this->assertSame('https://localhost/this-is-a-cms-link/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3, null, 'http');
        $this->assertSame('http://localhost/this-is-a-cms-link/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3, null, true);
        $this->assertSame('http://localhost/this-is-a-cms-link/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3, null, false);
        $this->assertSame('this-is-a-cms-link/controller/action', $r);
    }

    public function testCreateMenuItemUrlToOtherModule()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        Yii::$app->controller = new UrlStubController('stub', Yii::$app->getModule('unitmodule'));

        $r = $urlManager->createMenuItemUrl(['othermodule/controller/action'], 3);
        $this->assertStringContainsString('/othermodule/controller/action', $r);
        $r = $urlManager->createMenuItemUrl(['othermodule/controller/action'], 3, null, 'https');
        $this->assertStringContainsString('https://localhost', $r);
    }

    public function testCreateMenuItemUrlWithHomeItem()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class, 'getHome' => true]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3);
        $this->assertStringContainsString('/unitmodule/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 3, null, 'https');
        $this->assertStringContainsString('https://localhost', $r);
    }

    public function testCreateMenuItemUrlRedirectType2()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        Yii::$app->controller = new UrlStubController('stub', Yii::$app->getModule('unitmodule'));

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 2);
        $this->assertSame('this-is-a-module-type-page/controller/action', $r);

        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 2, null, 'http');
        $this->assertSame('http://localhost/this-is-a-module-type-page/controller/action', $r);
    }

    public function testCreateMenuItemUrlRedirectType2ToOtherModule()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        Yii::$app->controller = new UrlStubController('stub', Yii::$app->getModule('unitmodule'));

        $r = $urlManager->createMenuItemUrl(['othermodule/controller/action'], 2);
        $this->assertStringContainsString('/othermodule/controller/action', $r);
    }

    public function testCreateMenuItemUrlWithException()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        $this->expectException('yii\web\BadRequestHttpException');
        $r = $urlManager->createMenuItemUrl(['unitmodule/controller/action'], 1);
    }

    public function testCreateMenuItemUrlButUnableToFindModuleInRoute()
    {
        Yii::$app->set('menu', ['class' => UnitMenu::class]);
        $urlManager = new UrlManager();
        $menu = $urlManager->getMenu();
        $this->assertNotFalse($menu);

        $r = $urlManager->createMenuItemUrl(['moduledoesnotexists/controller/action'], 3);

        $this->assertStringContainsString('moduledoesnotexists/controller/action', $r);
    }

    /**
     * @see https://github.com/luyadev/luya/issues/1146
     */
    public function testCompositionRuleWithHiddenLanguageButCompositionLangShortCodeMatching()
    {
        $request = new Request();
        $request->pathInfo = 'mentions-legales';
        $composition = new Composition($request, ['hidden' => true, 'default' => ['langShortCode' => 'fr']]);
        $this->assertSame('fr', $composition->langShortCode);
        $urlManager = new UrlManager();
        $urlManager->composition = $composition;
        $urlManager->addRules([
            ['pattern' => '', 'route' => 'wirpre/default/index'],
            ['pattern' => 'impressum', 'route' => 'wirpre/default/imprint', 'composition' => ['fr' => 'mentions-legales']],
        ]);
        $parsed = $urlManager->parseRequest($request);

        $this->assertSame($composition->hidden, $urlManager->composition->hidden);
        $this->assertSame($composition->default, $urlManager->composition->default);
        $this->assertTrue($urlManager->routeHasLanguageCompositionPrefix('fr/foo/bar', 'fr'));
        $this->assertFalse($urlManager->routeHasLanguageCompositionPrefix('fr/foo/bar', 'de'));

        $this->assertSame('wirpre/default/imprint', $parsed[0]);
    }

    public function testCompositionRuleWithHiddenLanguageAsUrlCreation()
    {
        $request = new Request();
        $request->pathInfo = '/';
        $composition = new Composition($request, ['hidden' => true, 'default' => ['langShortCode' => 'fr']]);
        $urlManager = new UrlManager();
        $urlManager->composition = $composition;
        $urlManager->addRules([
                ['pattern' => '', 'route' => 'wirpre/default/index'],
                ['pattern' => 'impressum', 'route' => 'wirpre/default/imprint', 'composition' => ['fr' => 'mentions-legales']],
        ]);
        $url = $urlManager->createUrl(['/wirpre/default/imprint']);
        $this->assertStringContainsString('/mentions-legales', $url);
    }

    public function testCompositionRuleWithWhenPointingToAnotherLanguage()
    {
        $request = new Request();
        $request->pathInfo = '/';
        $composition = new Composition($request, ['hidden' => false, 'default' => ['langShortCode' => 'de']]);
        $urlManager = new UrlManager();
        $urlManager->composition = $composition;
        $urlManager->addRules([
                ['pattern' => '', 'route' => 'mymodule/default/index'],
                ['pattern' => 'impressum', 'route' => 'mymodule/default/imprint', 'composition' => ['fr' => 'mentions-legales']],
        ]);
        $url = $urlManager->createUrl(['/mymodule/default/imprint']);
        $this->assertStringContainsString('/impressum', $url);

        $url = $urlManager->createUrl(['fr/mymodule/default/imprint']);
        $this->assertStringContainsString('/mentions-legales', $url);

        $url = $urlManager->createUrl(['/fr/mymodule/default/imprint']);
        $this->assertStringContainsString('/mentions-legales', $url);
    }

    public function testUrlCreationWithComplexCompositionPattern()
    {
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'en-GB/admin', 'baseUrl' => '/']);
        $comp = new Composition($request, ['hidden' => false, 'pattern' => '<langShortCode:([a-z]{2}[\-]{1}[A-Z]{2})>', 'default' => ['langShortCode' => 'de-CH']]);

        $manager = new UrlManager();

        $this->assertSame('/luya/envs/dev/public_html/en-GB/', $manager->internalCreateUrl(['/'], $comp));
    }
}
