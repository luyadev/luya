<?php

namespace luyatests\core\web;

use luya\web\Request;
use luya\web\Composition;

/**
 * removed tests to implemented here (if not already).
 *
 *
 $parts = Yii::$app->composition->get();

 $this->assertArrayHasKey('langShortCode', $parts);
 $this->assertArrayHasKey('foo', $parts);
 $this->assertArrayHasKey('bar', $parts);

 $this->assertEquals('de', $parts['langShortCode']);
 $this->assertEquals('de', Yii::$app->composition->getLanguage());
 $this->assertEquals('1234', $parts['foo']);
 $this->assertEquals('luya09', $parts['bar']);

 *
 * @author nadar
 */
class CompositionTest extends \luyatests\LuyaWebTestCase
{
    public function testResolvedPaths()
    {
        $request = new Request();
        $request->pathInfo = 'de/hello/world';

        $composition = new \luya\web\Composition($request);

        $resolver = $composition->getResolvedPathInfo($request);
        $resolve = $resolver['route'];
        $resolved = $resolver['resolvedValues'];

        $this->assertEquals('hello/world', $resolve);
        $this->assertEquals(true, is_array($resolved));
        $this->assertEquals(1, count($resolved));
        $this->assertArrayHasKey('langShortCode', $resolved);
        $this->assertEquals('de', $resolved['langShortCode']);
    }

    public function testMultipleResolvedPaths()
    {
        $request = new Request();
        $request->pathInfo = 'ch/de/hello/world';

        $composition = new \luya\web\Composition($request);
        $composition->pattern = '<countryShortCode:[a-z]{2}>/<langShortCode:[a-z]{2}>';

        $resolver = $composition->getResolvedPathInfo($request);
        $resolve = $resolver['route'];
        $resolved = $resolver['resolvedValues'];

        $this->assertEquals('hello/world', $resolve);
        $this->assertEquals(true, is_array($resolved));
        $this->assertEquals(2, count($resolved));
        $this->assertArrayHasKey('countryShortCode', $resolved);
        $this->assertEquals('ch', $resolved['countryShortCode']);
        $this->assertArrayHasKey('langShortCode', $resolved);
        $this->assertEquals('de', $resolved['langShortCode']);
    }

    private function resolveHelper($url, $compUrl)
    {
        $request = new Request();
        $request->pathInfo = $url;

        $composition = new \luya\web\Composition($request);
        $composition->pattern = $compUrl;

        return $composition->getResolvedPathInfo($request);
    }

    public function testGetResolvedPathInfo()
    {
        $comp = '<countryShortCode:[a-z]{2}>';

        $resolve = $this->resolveHelper('ch/de/hello/world', $comp);
        $this->assertEquals('de/hello/world', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);

        $resolve = $this->resolveHelper('ch/de/hello', $comp);
        $this->assertEquals('de/hello', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);

        $resolve = $this->resolveHelper('ch/de', $comp);
        $this->assertEquals('de', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);

        $resolve = $this->resolveHelper('ch/', $comp);
        $this->assertEquals('', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);

        $comp = '<countryShortCode:[a-z]{2}>/<do:[a-z]{2}>';

        $resolve = $this->resolveHelper('ch/de/hello/world', $comp);
        $this->assertEquals('hello/world', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);
        $this->assertEquals('de', $resolve['resolvedValues']['do']);

        $resolve = $this->resolveHelper('ch/de/hello', $comp);
        $this->assertEquals('hello', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);
        $this->assertEquals('de', $resolve['resolvedValues']['do']);

        $resolve = $this->resolveHelper('ch/de', $comp);
        $this->assertEquals('', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);
        $this->assertEquals('de', $resolve['resolvedValues']['do']);

        $resolve = $this->resolveHelper('ch/', $comp);

        $this->assertEquals('', $resolve['route']);
        $this->assertEquals('ch', $resolve['resolvedValues']['countryShortCode']);
    }
    
    public function testMultiDomainMapping()
    {
        $request = new Request();
        $request->pathInfo = 'foo/bar';
        $request->hostInfo = 'example.fr';
        
        $composition = new \luya\web\Composition($request, [
            'hostInfoMapping' => ['example.fr' => ['langShortCode' => 'fr', 'x' => 'y']]
        ]);
        
        $resolv = $composition->getResolvedPathInfo($request);
        
        $this->assertEquals('fr', $resolv['compositionKeys']['langShortCode']);
        $this->assertTrue(isset($resolv['compositionKeys']['x']));
    }
    
    public function testGetDefaultLanguage()
    {
        $request = new Request();
        $comp = new Composition($request);
        $this->assertEquals('en', $comp->getDefaultLangShortCode());
        
        // test route override
        $override = $comp->createRoute(['langShortCode' => 'us']);
        
        $this->assertEquals('us', $override);
        
        // as override does not set/change the base value
        $this->assertEquals('en', $comp->getLanguage());
        $this->assertEquals('en', $comp['langShortCode']);
        $this->assertTrue(isset($comp['langShortCode']));
        $comp['fooCode'] = 'bar';
        $this->assertEquals('bar', $comp['fooCode']);
    }
    
    public function testGetKeys()
    {
        $request = new Request();
        $comp = new Composition($request);
        $this->assertTrue(is_array($comp->get()));
        $this->assertArrayHasKey('langShortCode', $comp->get());
    }
    
    /**
     * @expectedException Exception
     */
    public function testExceptionOnInit()
    {
        $request = new Request();
        $comp = new Composition($request, ['default' => ['noLangShortCode' => 'ch']]);
    }
    
    /**
     * @expectedException Exception
     */
    public function testEmptyAssignException()
    {
        $request = new Request();
        $comp = new Composition($request);
        $comp[] = 'bar';
    }
    
    /**
     * @expectedException Exception
     */
    public function testNotAllowedUnset()
    {
        $request = new Request();
        $comp = new Composition($request);
        unset($comp['langShortCode']);
    }
    
    public function testRemoval()
    {
        $request = new Request();
        $request->pathInfo = 'foo/bar';
        $request->hostInfo = 'example.fr';
        $comp = new Composition($request);
        $comp->hidden = false;
        
        $this->assertEquals('this-should/be-left', $comp->removeFrom('en/this-should/be-left'));
    }
    
    public function testAllowedHosts()
    {
        $request = new Request();
        $comp = new Composition($request);
        $this->assertTrue($comp->isHostAllowed(['localhost']));
    }
    
    public function testAllowedHostsItems()
    {
        $request = new Request();
        $request->hostInfo = 'http://www.foobar.com';
        $comp = new Composition($request);
        $this->assertTrue($comp->isHostAllowed(['www.foobar.com']));
    }
    
    public function testAllowedHostsItemsWildcard()
    {
        $request = new Request();
        $request->hostInfo = 'http://www.foobar.com';
        $comp = new Composition($request);
        $this->assertTrue($comp->isHostAllowed(['*.foobar.com']));
        $this->assertFalse($comp->isHostAllowed(['luya.io']));
        $this->assertTrue($comp->isHostAllowed(['luya.io', 'www.foobar.com']));
    }
    
    public function testAllowedHostsExceptions()
    {
        $request = new Request();
        $comp = new Composition($request);
        $this->assertFalse($comp->isHostAllowed(['foobar.com']));
    }
}
