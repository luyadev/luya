<?php

namespace luyatests\core\web;

use luya\web\Application;
use luya\web\Request;
use luyatests\LuyaWebTestCase;

class ApplicationTest extends LuyaWebTestCase
{
    public function testInsecureConnectionException()
    {
        $request = new Request(['pathInfo' => 'test/path']);
        $app = new Application(['id' => 'insecure-app', 'basePath' => __DIR__, 'ensureSecureConnection' => true]);
        $this->expectException('yii\web\ForbiddenHttpException');
        $app->handleRequest($request);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSecureConnectionCookieAndHeaders()
    {
        $_SERVER['HTTPS'] = 'on';
        $request = new Request(['pathInfo' => 'foo']);
        $app = new Application(['id' => 'insecure-app', 'basePath' => __DIR__, 'ensureSecureConnection' => true]);
        $app->controllerMap = ['foo' => 'luyatests\data\controllers\FooController'];

        $response = $app->handleRequest($request);

        $this->assertSame('max-age=31536000', $response->headers->get('Strict-Transport-Security'));
        $this->assertSame('1; mode=block', $response->headers->get('X-XSS-Protection'));
        $this->assertSame('SAMEORIGIN', $response->headers->get('X-Frame-Options'));

        $this->assertSame('bar', $response->data);
    }
}
