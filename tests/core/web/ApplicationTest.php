<?php

namespace luyatests\core\web;

use luyatests\LuyaWebTestCase;
use luya\web\Application;
use luya\web\Request;

class ApplicationTest extends LuyaWebTestCase
{
    public function testInsecureConnectionException()
    {
        $request = new Request(['pathInfo' => 'test/path']);
        $app = new Application(['id' => 'insecure-app', 'basePath' => __DIR__, 'ensureSecureConnection' => true]);
        $this->expectException('yii\web\ForbiddenHttpException');
        $app->handleRequest($request);
    }
}