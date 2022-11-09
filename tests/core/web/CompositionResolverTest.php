<?php

namespace luya\tests\core\web;

use luya\web\Composition;
use luya\web\CompositionResolver;
use luya\web\Request;
use luyatests\LuyaWebTestCase;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

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

    public function testExpectedValuesResolver()
    {
        $request = new Request();
        $request->pathInfo = 'en/foo/bar';

        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>/<xyz:[a-z]{3}>';
        $composition->expectedValues = [
            'lang' => ['en'],
            'xyz' => ['foo'],
        ];

        $resolver = new CompositionResolver($request, $composition);
        $this->assertSame(['lang' => 'en', 'xyz' => 'foo'], $resolver->resolvedValues);

        $request = new Request();
        $request->pathInfo = 'de/foo/bar';

        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>/<xyz:[a-z]{3}>';
        $composition->expectedValues = [
            'lang' => ['en'],
            'xyz' => ['foo'],
        ];

        $resolver = new CompositionResolver($request, $composition);

        $this->expectException(NotFoundHttpException::class);
        $resolver->resolvedValues;
    }

    public function testExpectedResolverWithEmptyValuesButDefaults()
    {
        $request = new Request();
        $request->pathInfo = '';

        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>/<xyz:[a-z]{3}>';
        $composition->default = ['lang' => 'en', 'xyz' => 'foo'];
        $composition->expectedValues = [
            'lang' => ['en'],
            'xyz' => ['foo'],
        ];

        $resolver = new CompositionResolver($request, $composition);
        $this->assertSame(['lang' => 'en', 'xyz' => 'foo'], $resolver->resolvedValues);

        $request = new Request();
        $request->pathInfo = '';

        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>/<xyz:[a-z]{3}>';
        $composition->default = ['lang' => 'en', 'xyz' => 'foo'];
        $composition->expectedValues = [
            'lang' => ['de'],
            'xyz' => ['foo'],
        ];

        $resolver = new CompositionResolver($request, $composition);
        $this->expectException(NotFoundHttpException::class);
        $resolver->resolvedValues;
    }

    public function testInvalidConfigurationForExpectedValues()
    {
        $request = new Request();
        $request->pathInfo = '';

        $composition = new Composition($request);
        $composition->pattern = '<lang:[a-z]{2}>/<xyz:[a-z]{3}>';
        $composition->default = ['lang' => 'en', 'xyz' => 'foo'];
        $composition->expectedValues = [
            'doesnotexists' => ['en'],
        ];

        $resolver = new CompositionResolver($request, $composition);
        $this->expectException(InvalidConfigException::class);
        $resolver->resolvedValues;
    }
}
