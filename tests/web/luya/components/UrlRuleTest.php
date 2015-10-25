<?php

namespace tests\web\luya\components;

use Yii;
use luya\web\components\Request;
use luya\web\components\UrlManager;
/**
 * @author nadar
 */
class UrlRuleTest extends \tests\web\Base
{
    public function testParseRequest()
    {
        Yii::$app->composition->pattern = '<langShortCode:[a-z]{2}>/<foo:[0-9]{4}>/<bar:[a-z0-9]+>';

        $request = new Request();
        $request->pathInfo = 'de/1234/luya09/my/website';

        $manager = new UrlManager();
        $rule = new \luya\components\UrlRule();

        $response = $rule->parseRequest($manager, $request);

        $this->assertArrayHasKey('0', $response);
        $this->assertArrayHasKey('1', $response);
        $this->assertArrayHasKey('path', $response[1]);

        $this->assertEquals('cms/default/index', $response[0]);
        $this->assertEquals('my/website', $response[1]['path']);

        $parts = Yii::$app->composition->get();

        $this->assertArrayHasKey('langShortCode', $parts);
        $this->assertArrayHasKey('foo', $parts);
        $this->assertArrayHasKey('bar', $parts);

        $this->assertEquals('de', $parts['langShortCode']);
        $this->assertEquals('de', Yii::$app->composition->getLanguage());
        $this->assertEquals('1234', $parts['foo']);
        $this->assertEquals('luya09', $parts['bar']);
    }

    public function testNotExistingUrlRule()
    {
        $request = new Request();
        $request->pathInfo = '/news';

        $manager = new UrlManager();
        $rule = new \luya\components\UrlRule();

        // first part and not a module. equals false;
        $this->assertEquals(false, $rule->parseRequest($manager, $request));
    }

    public function testUrlParts()
    {
        $request = new Request();
        $request->pathInfo = '';

        $rule = new \luya\components\UrlRule();

        $this->assertEquals(true, is_array($rule->getUrlParts($request)));
        $this->assertEquals(0, count($rule->getUrlParts($request)));

        $request = new Request();
        $request->pathInfo = '/news';

        $this->assertEquals(true, is_array($rule->getUrlParts($request)));
        $this->assertEquals(1, count($rule->getUrlParts($request)));

        $request = new Request();
        $request->pathInfo = '/news/';

        $this->assertEquals(true, is_array($rule->getUrlParts($request)));
        $this->assertEquals(1, count($rule->getUrlParts($request)));
    }
    
    public function testReslvedWithLeadingCompositionPrefix()
    {
        $en = $this->callUrl('/en');
        $de = $this->callUrl('/de');
        $sw = $this->callUrl('/sw');
        $fbar = $this->callUrl('/de/foobar');
        $none = $this->callUrl('/');

        $this->assertEquals("cms/default/index", $en[0]);
        $this->assertEquals("cms/default/index", $de[0]);
        $this->assertEquals("cms/default/index", $sw[0]);
        $this->assertEquals("cms/default/index", $fbar[0]);
        $this->assertEquals(false, $none);
        
        $this->assertEquals("", $en[1]['path']);
        $this->assertEquals("", $de[1]['path']);
        $this->assertEquals("", $sw[1]['path']);
        $this->assertEquals("foobar", $fbar[1]['path']);
    }
    
    private function callUrl($url) 
    {
        $request = new Request();
        $request->pathInfo = $url;
        
        $manager = new UrlManager();
        $rule = new \luya\components\UrlRule();
        
        return $rule->parseRequest($manager, $request);
    }
}
