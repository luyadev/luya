<?php

namespace luyatests\core\web;

use luya\web\Composition;
use luya\web\Request;

/**
 * removed tests to implemented here (if not already).
 *
 *
 *
 * @author nadar
 */
class CompositionTest extends \luyatests\LuyaWebTestCase
{
    private function resolveHelper($url, $compUrl)
    {
        $request = new Request();
        $request->pathInfo = $url;

        $composition = new Composition($request);
        $composition->pattern = $compUrl;

        return $composition->getResolvedPathInfo($request);
    }

    public function testResolveHostInfo()
    {
        $request = new Request();
        $comp = new Composition($request);

        // basic tests
        $comp->hostInfoMapping = [
            'http://mydomain.com' => ['langShortCode' => 'en'],
            'http://meinedomain.de' => ['langShortCode' => 'de'],
        ];
        $this->assertSame('http://meinedomain.de', $comp->resolveHostInfo('de'));
        $this->assertSame('http://mydomain.com', $comp->resolveHostInfo('en'));

        // advanced config tests
        $comp->hostInfoMapping = [
            'http://mydomain.com' => ['langShortCode' => 'en', 'countryPrefix' => 'en'],
            'http://mydomain.ch' => ['langShortCode' => 'de', 'countryPrefix' => 'ch'],
            'http://meinedomain.de' => ['langShortCode' => 'de', 'countryPrefix' => 'de'],
        ];
        $this->assertSame('http://meinedomain.de', $comp->resolveHostInfo(['langShortCode' => 'de', 'countryPrefix' => 'de']));
        $this->assertSame('http://mydomain.ch', $comp->resolveHostInfo(['langShortCode' => 'de', 'countryPrefix' => 'ch']));
        $this->assertSame('http://mydomain.com', $comp->resolveHostInfo(['langShortCode' => 'en', 'countryPrefix' => 'en']));

        // wrong (double) config defintion resolver
        $comp->hostInfoMapping = [
            'http://mydomain.com' => ['langShortCode' => 'en', 'countryPrefix' => 'en'],
            'http://mydomain.ch' => ['langShortCode' => 'de', 'countryPrefix' => 'ch'],
            'http://meinedomain.de' => ['langShortCode' => 'de', 'countryPrefix' => 'ch'],
        ];
        $this->assertFalse($comp->resolveHostInfo(['langShortCode' => 'de', 'countryPrefix' => 'de']));
        $this->assertSame('http://mydomain.ch', $comp->resolveHostInfo(['langShortCode' => 'de', 'countryPrefix' => 'ch']));
        $this->assertSame('http://mydomain.com', $comp->resolveHostInfo(['langShortCode' => 'en', 'countryPrefix' => 'en']));

        // not found config
        $comp->hostInfoMapping = [
            'http://mydomain.com' => ['langShortCode' => 'en'],
            'http://meinedomain.de' => ['langShortCode' => 'de'],
        ];
        $this->assertFalse($comp->resolveHostInfo('cn'));
    }

    public function testEmptyRouteResolver()
    {
        $resolve = $this->resolveHelper('ch/', '<countryShortCode:[a-z]{2}>');
        $this->assertEquals('', $resolve->resolvedPath);
        $this->assertEquals(['countryShortCode' => 'ch'], $resolve->resolvedValues);
    }

    public function testResolvedPaths()
    {
        $request = new Request();
        $request->pathInfo = 'de/hello/world';

        $composition = new \luya\web\Composition($request);

        $resolver = $composition->getResolvedPathInfo($request);

        $this->assertEquals('hello/world', $resolver->resolvedPath);
        $this->assertSame(['langShortCode' => 'de'], $resolver->resolvedValues);
        $this->assertSame(['langShortCode'], $resolver->resolvedKeys);
    }

    public function testMultipleResolvedPaths()
    {
        $request = new Request();
        $request->pathInfo = 'ch/de/hello/world';

        $composition = new \luya\web\Composition($request);
        $composition->pattern = '<countryShortCode:[a-z]{2}>/<langShortCode:[a-z]{2}>';

        $resolver = $composition->getResolvedPathInfo($request);
        $resolve = $resolver->resolvedPath;
        $resolved = $resolver->resolvedValues;

        $this->assertEquals('hello/world', $resolve);
        $this->assertEquals(true, is_array($resolved));
        $this->assertEquals(2, count($resolved));
        $this->assertArrayHasKey('countryShortCode', $resolved);
        $this->assertEquals('ch', $resolved['countryShortCode']);
        $this->assertArrayHasKey('langShortCode', $resolved);
        $this->assertEquals('de', $resolved['langShortCode']);
        $this->assertEquals('de', $composition['langShortCode']);
    }



    public function testGetResolvedPathInfo()
    {
        $comp = '<countryShortCode:[a-z]{2}>';

        $resolve = $this->resolveHelper('ch/de/hello/world', $comp);
        $this->assertEquals('de/hello/world', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);

        $resolve = $this->resolveHelper('ch/de/hello', $comp);
        $this->assertEquals('de/hello', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);

        $resolve = $this->resolveHelper('ch/de', $comp);
        $this->assertEquals('de', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);

        $resolve = $this->resolveHelper('ch/', $comp);
        $this->assertEquals('', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);

        $comp = '<countryShortCode:[a-z]{2}>/<do:[a-z]{2}>';

        $resolve = $this->resolveHelper('ch/de/hello/world', $comp);
        $this->assertEquals('hello/world', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);
        $this->assertEquals('de', $resolve->resolvedValues['do']);

        $resolve = $this->resolveHelper('ch/de/hello', $comp);
        $this->assertEquals('hello', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);
        $this->assertEquals('de', $resolve->resolvedValues['do']);

        $resolve = $this->resolveHelper('ch/de', $comp);
        $this->assertEquals('', $resolve->resolvedPath);
        $this->assertEquals('ch', $resolve->resolvedValues['countryShortCode']);
        $this->assertEquals('de', $resolve->resolvedValues['do']);

        // this rule wont match the the composition pattern, therfore the composition would not apply ore remove
        // any data from the path and returns the default values from the composition.
        $resolve = $this->resolveHelper('ch/', $comp);
        $this->assertEquals('ch', $resolve->resolvedPath);
        $this->assertEquals('en', $resolve->resolvedValues['langShortCode']);
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

        $this->assertSame(['langShortCode' => 'fr', 'x' => 'y'], $resolv->resolvedValues);
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
        $this->assertEquals('en', $comp->getLangShortCode());
        $this->assertEquals('en', $comp['langShortCode']);
        $this->assertTrue(isset($comp['langShortCode']));
        $comp['fooCode'] = 'bar';
        $this->assertEquals('bar', $comp['fooCode']);
    }

    public function testGetKeys()
    {
        $request = new Request();
        $comp = new Composition($request);
        $this->assertArrayHasKey('langShortCode', $comp->getKeys());
    }


    public function testNewDefaultMethods()
    {
        $request = new Request();
        $request->pathInfo = 'fr/hello-world';
        $comp = new Composition($request);
        $comp->hidden = false;

        $this->assertSame('en', $comp->getDefaultLangShortCode());
        $this->assertSame('fr', $comp->getLangShortCode());
        $this->assertSame('fr', $comp->getPrefixPath());
    }

    public function testNewDefaultMehtodsPattern()
    {
        // change pathInfo and pattern
        $request = new Request();
        $request->pathInfo = 'de/ch/hello-world';
        $comp = new Composition($request);
        $comp->pattern = '<langShortCode:[a-z]{2}>/<countryShortCode:[a-z]{2}>';
        $comp->hidden = false;

        $this->assertSame('en', $comp->getDefaultLangShortCode());
        $this->assertSame('de', $comp->getLangShortCode());
        $this->assertSame('de/ch', $comp->getPrefixPath());
    }

    public function testExtractCompositionData()
    {
        $request = new Request();
        $request->pathInfo = 'de-ch/hello-world';

        $comp = new Composition($request);
        $comp->pattern = '<langShortCode:[a-z]{2}>-<countryShortCode:[a-z]{2}>';
        $result = $comp->getResolvedPathInfo($request);


        $this->assertSame('hello-world', $result->resolvedPath);
        $this->assertSame([
            'langShortCode' => 'de',
            'countryShortCode' => 'ch',
        ], $result->resolvedValues);
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

    public function testMultipleWildcardAllowedHosts()
    {
        $request = new Request();
        $request->hostInfo = 'https://www.luya.io';
        $this->assertSame($request->hostName, 'www.luya.io');
        $comp = new Composition($request);
        $this->assertFalse($comp->isHostAllowed(['luya.io']));

        $this->assertTrue($comp->isHostAllowed(['*luya.io']));
        $this->assertTrue($comp->isHostAllowed(['*.luya.io']));

        // should be false as www. does not exitss
        $request = new Request();
        $request->hostInfo = 'https://luya.io';
        $this->assertSame($request->hostName, 'luya.io');
        $comp = new Composition($request);
        $this->assertFalse($comp->isHostAllowed(['*.luya.io']));
    }

    public function testAllowedHostsPreviewDomainWildcard()
    {
        $commonPreviewUrls = 'https://luya.io.12-34-45-67.example.com';
        $request = new Request();
        $request->hostInfo = $commonPreviewUrls;
        $this->assertSame($request->hostName, 'luya.io.12-34-45-67.example.com');
        $comp = new Composition($request);
        $this->assertFalse($comp->isHostAllowed(['luya.io']));
        $this->assertFalse($comp->isHostAllowed(['*luya.io']));
        $this->assertTrue($comp->isHostAllowed(['luya.io*']));
        $this->assertFalse($comp->isHostAllowed(['example.com']));
        $this->assertTrue($comp->isHostAllowed(['*.example.com']));
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

    public function testExceptionOnInit()
    {
        $this->expectException('Exception');
        $request = new Request();
        $comp = new Composition($request, ['default' => ['noLangShortCode' => 'ch']]);
    }

    public function testNotAllowedUnset()
    {
        $this->expectException('Exception');
        $request = new Request();
        $comp = new Composition($request);
        unset($comp['langShortCode']);
    }

    public function testComplexLangShortCode()
    {
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'en-GB/admin']);
        $comp = new Composition($request, ['hidden' => false, 'pattern' => '<langShortCode:([a-z]{2}[\-]{1}[A-Z]{2})>', 'default' => ['langShortCode' => 'de-CH']]);

        $this->assertSame('en-GB', $comp->createRoute());
        $this->assertSame('de-CH', $comp->getDefaultLangShortCode());
        $this->assertSame('en-GB/foobar', $comp->prependTo('foobar'));
        $this->assertSame('en-GB', $comp->getPrefixPath());
        $this->assertSame('en-GB/', $comp->prependTo('/'));
        $this->assertSame(['langShortCode' => 'en-GB'], $comp->getKeys());

        // test prepending
        $this->assertSame('en-GB/', $comp->prependTo('', $comp->createRoute()));
        $this->assertSame('en-GB/f', $comp->prependTo('f', $comp->createRoute()));
        $this->assertSame('en-GB/f', $comp->prependTo('f'));
        $this->assertSame('en-GB/', $comp->prependTo(''));

        $resolver = $comp->getResolvedPathInfo($request);

        $this->assertSame('admin', $resolver->resolvedPath);
        $this->assertSame(['langShortCode' => 'en-GB'], $resolver->resolvedValues);
        $this->assertSame(['langShortCode'], $resolver->resolvedKeys);
    }

    public function testHideDefaultPrefixOnly()
    {
        // none hidden
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'de/hello/world']);
        $composition = new Composition($request, ['hidden' => false, 'default' => ['langShortCode' => 'en']]);
        $this->assertSame('de', $composition->createRouteEnsure());
        $composition = new Composition($request, ['hidden' => false, 'default' => ['langShortCode' => 'de']]);
        $this->assertSame('de', $composition->createRouteEnsure());

        // hidden
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'de/hello/world']);
        $composition = new Composition($request, ['hidden' => true, 'default' => ['langShortCode' => 'en']]);
        $this->assertSame('', $composition->createRouteEnsure());
        $composition = new Composition($request, ['hidden' => true, 'default' => ['langShortCode' => 'de']]);
        $this->assertSame('', $composition->createRouteEnsure());

        // not hidden but hide default prefix only
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'de/hello/world']);
        $composition = new Composition($request, ['hidden' => false, 'hideDefaultPrefixOnly' => true, 'default' => ['langShortCode' => 'en']]);
        $this->assertSame('de', $composition->createRouteEnsure()); // is not hidden cause default is `en` and provided in the url is `de/hello/world`.
        $composition = new Composition($request, ['hidden' => false, 'hideDefaultPrefixOnly' => true, 'default' => ['langShortCode' => 'de']]);
        $this->assertSame('', $composition->createRouteEnsure()); // is default `de` and also provided in the url `de/hello/world`

        // not hidden while overriding with alternative to current lang code
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'de/hello/world']);
        $composition = new Composition($request, ['hidden' => false, 'hideDefaultPrefixOnly' => true, 'default' => ['langShortCode' => 'de']]);
        $this->assertSame('fr', $composition->createRouteEnsure(['langShortCode' => 'fr']));

        // hidden while overriding with alternative to current, but equal to default lang code
        $request = new Request(['hostInfo' => 'http://localhost', 'pathInfo' => 'de/hello/world']);
        $composition = new Composition($request, ['hidden' => false, 'hideDefaultPrefixOnly' => true, 'default' => ['langShortCode' => 'en']]);
        $this->assertSame('', $composition->createRouteEnsure(['langShortCode' => 'en']));
    }
}
