<?php

namespace luya\tests\core\web;

use luyatests\LuyaWebTestCase;
use luya\web\CompositionResolver;
use luya\web\Request;
use luya\web\Composition;

class CompositionResolverTest extends LuyaWebTestCase
{
    public function testBasicResolver()
    {
        $request = new Request();
        $request->pathInfo = 'de/foo/bar';
        
        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>';
        $composition->default = ['lang' => 'fr'];

        $resolver = new CompositionResolver($request, $composition);
        $this->assertSame(['lang' => 'de'], $resolver->resolvedValues);
    }
}
