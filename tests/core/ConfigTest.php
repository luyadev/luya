<?php

namespace luyatests\core;

use luya\Config;
use luyatests\LuyaWebTestCase;

class ConfigTest extends LuyaWebTestCase
{
   
    public function testAssembling()
    {
        $config = new Config('id', 'basePath', [
            'defaultRoute' => 'cms',
        ]);

        $config->component('request', [
            'secureHeaders' => [],
        ]);

        $config->module('admin', 'luya\admin\Module');
        $config->module('cms', ['class' => 'luya\cms\frontend\Module']);

        $this->assertSame([
            'defaultRoute' => 'cms',
            'id' => 'id',
            'basePath' => 'basePath',
            'components' => [
                'request' => [
                    'secureHeaders' => [],
                ]
            ],
            'modules' => [
                'admin' => [
                    'class' => 'luya\admin\Module',
                ],
                'cms' => [
                    'class' => 'luya\cms\frontend\Module',
                ]
            ]
        ], $config->toArray());
    }

    public function testWebapplication()
    {
        $config = new Config('web', 'basePath');
        $config->setCliRuntime(false);
        $config->webComponent('request', [
            'secureHeaders' => [],
        ]);
        $config->consoleComponent('request', [
            'someCliEnvProperty' => true,
        ]);

        $this->assertSame([
            'id' => 'web',
            'basePath' => 'basePath',
            'components' => [
                'request' => [
                    'secureHeaders' => []
                ]
            ]
        ], $config->toArray());
    }

    public function testConsoleApplication()
    {
        $config = new Config('console', 'basePath');
        $config->setCliRuntime(true);
        $config->webComponent('request', [
            'secureHeaders' => [],
        ]);
        $config->consoleComponent('request', [
            'someCliEnvProperty' => true,
        ]);

        $this->assertSame([
            'id' => 'console',
            'basePath' => 'basePath',
            'components' => [
                'request' => [
                    'someCliEnvProperty' => true,
                ]
            ]
        ], $config->toArray());
    }

    public function testMergeOfTwoComponenets()
    {
        $config = new Config('web', 'basePath');
        $config->setCliRuntime(false);
        $config->webComponent('request', [
            'secureHeaders' => [],
        ]);
        $config->component('request', [
            'cookieValidationKey' => 'test',
        ]);

        $this->assertSame([
            'id' => 'web',
            'basePath' => 'basePath',
            'components' => [
                'request' => [
                    'secureHeaders' => [],
                    'cookieValidationKey' => 'test',
                ]
            ]
        ], $config->toArray());
    }

    public function testGetEnvBasedData()
    {
        $config = new Config('web', 'basePath', [
            'generic' => 'generic'
        ]);

        $config->application(['local' => 'bar'])->env(Config::ENV_LOCAL);
        $config->component('prod', 'bar')->env(Config::ENV_PROD);
        $config->component('custom', 'bar')->env('customname');

        $this->assertSame([
            'generic' => 'generic',
            'id' => 'web',
            'basePath' => 'basePath',
            'local' => 'bar',
            'components' => [
                'custom' => [
                    'class' => 'bar'
                ]
            ]
        ], $config->toArray(['customname', Config::ENV_LOCAL]));
    }
}