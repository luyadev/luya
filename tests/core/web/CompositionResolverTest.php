<?php

namespace luya\tests\core\web;

use luyatests\LuyaWebTestCase;
use luya\web\CompositionResolver;
use luya\web\Request;

class CompositionResolverTest extends LuyaWebTestCase
{
    public function testBasicResolver()
    {
        $request = new Request();
        $request->pathInfo = 'de/foo/bar';
        
        $resolver = new CompositionResolver($request);
        $resolver->pattern = '<lang:[a-z]{2}>';
        $resolver->defaultValues = ['lang' => 'fr'];
        
        $this->assertSame(['lang' => 'de'], $resolver->resolvedValues);
    }
}