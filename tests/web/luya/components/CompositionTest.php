<?php

namespace tests\web\luya\components;

class CompositionTest extends \tests\web\Base
{
    public function testResolvedPaths()
    {
        $request = new \luya\components\Request();
        $request->pathInfo = 'de/hello/world';
        
        $composition = new \luya\components\Composition();
        $resolve = $composition->getResolvedPathInfo($request);
        $resolved = $composition->getResolvedValues();
        
        $this->assertEquals('hello/world', $resolve);
        $this->assertEquals(true, is_array($resolved));
        $this->assertEquals(1, count($resolved));
        $this->assertArrayHasKey(0, $resolved);
        $this->assertEquals('de', $resolved[0]);
    }
    
    public function testMultipleResolvedPaths()
    {
        $request = new \luya\components\Request();
        $request->pathInfo = 'ch/de/hello/world';
        
        $composition = new \luya\components\Composition();
        $composition->pattern = '<countryShortCode:[a-z]{2}>/<langShortCode:[a-z]{2}>';
        
        $resolve = $composition->getResolvedPathInfo($request);
        $resolved = $composition->getResolvedValues();
        
        $this->assertEquals('hello/world', $resolve);
        $this->assertEquals(true, is_array($resolved));
        $this->assertEquals(2, count($resolved));
        $this->assertArrayHasKey(0, $resolved);
        $this->assertEquals('ch', $resolved[0]);
        $this->assertArrayHasKey(1, $resolved);
        $this->assertEquals('de', $resolved[1]);
    }
}