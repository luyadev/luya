<?php

namespace tests\src;

use Yii;
use luya\helpers\Url;

/**
 * 
 * @author nadar
 *
 */
class LuyaUrlRuleTest extends \tests\BaseTest
{
    public function testParseRequest()
    {
        Yii::$app->getModule('luya')->urlPrefixComposition = '<langShortCode:[a-z]{2}>/<foo:[0-9]{4}>/<bar:[a-z0-9]+>';
        
        $request = new \yii\web\Request();
        $request->pathInfo = 'de/1234/luya09/my/website';
        
        $manager = new \luya\components\UrlManager();
        $rule = new \luya\components\UrlRule();
        
        $response = $rule->parseRequest($manager, $request);
        
        $this->assertArrayHasKey("0", $response);
        $this->assertArrayHasKey("1", $response);
        $this->assertArrayHasKey("path", $response[1]);
        
        $this->assertEquals("cms/default/index", $response[0]);
        $this->assertEquals("my/website", $response[1]['path']);
        
        $parts = Yii::$app->composition->get();
        
        $this->assertArrayHasKey("langShortCode", $parts);
        $this->assertArrayHasKey("foo", $parts);
        $this->assertArrayHasKey("bar", $parts);
        
        $this->assertEquals("de", $parts['langShortCode']);
        $this->assertEquals("de", Yii::$app->composition->getLanguage());
        $this->assertEquals("1234", $parts['foo']);
        $this->assertEquals("luya09", $parts['bar']);
    }
}