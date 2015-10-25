<?php

namespace tests\web\luya\components;

use luya\web\components\Request;

class CompositionTest extends \tests\web\Base
{
    public function testResolvedPaths()
    {
        $request = new Request();
        $request->pathInfo = 'de/hello/world';

        $composition = new \luya\components\Composition();
        
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

        $composition = new \luya\components\Composition();
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
        
        $composition = new \luya\components\Composition();
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
}
