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

        $this->assertTrue($config->isCliRuntime());

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

    public function testSwitchOfRuntimeForExistingComponent()
    {
        $config = new Config('switch', 'basePath');
        $config->setCliRuntime(true);

        $config->component('test', ['web' => true])->webRuntime();
        $config->component('test', ['console' => true])->consoleRuntime();

        $this->assertSame([
            'id' => 'switch',
            'basePath' => 'basePath',
            'components' => [
                'test' => [
                    'console' => true
                ]
            ]
        ], $config->toArray());
    }

    public function testComponentEnvMerging()
    {
        $config = new Config('test', 'basePath');
        $config->component('db', 'yii\db\Connection');

        $config->component('db', [
            'username' => 'prod',
            'password' => 'prod',
        ])->env(Config::ENV_PROD);

        $config->component('db', [
            'username' => 'prep',
            'password' => 'prep',
        ])->env(Config::ENV_PREP);

        $this->assertSame([
            'id' => 'test',
            'basePath' => 'basePath',
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'username' => 'prod',
                    'password' => 'prod',
                ]
            ]
        ], $config->toArray([Config::ENV_PROD]));

        $this->assertSame([
            'id' => 'test',
            'basePath' => 'basePath',
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'username' => 'prep',
                    'password' => 'prep',
                ]
            ]
        ], $config->toArray([Config::ENV_PREP]));


        $this->assertSame([
            'id' => 'test',
            'basePath' => 'basePath',
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'username' => 'prep',
                    'password' => 'prep',
                ]
            ]
        ], $config->toArray(Config::ENV_PREP));
    }

    public function testBootstrap()
    {
        $config = new Config('bootstrap', 'basePath');
        $config->bootstrap(['id1', 'id2']);
        $config->bootstrap(['id3']);

        $this->assertSame([
            'id' => 'bootstrap',
            'basePath' => 'basePath',
            'bootstrap' => [
                'id1', 'id2', 'id3'
            ]
        ], $config->toArray());
    }

    public function testEnvScope()
    {
        $config = new Config('web', 'basePath', [
            'common' => 'common'
        ]);

        $config->env(Config::ENV_LOCAL, function (Config $config) {
            $config->application(['local' => 'bar']);
        });

        $config->env(Config::ENV_PROD, function (Config $config) {
            $config->component('prod', 'bar');
            $config->component('prod2', 'foo');
        });

        $config->env('customname', function (Config $config) {
            $config->component('custom', 'bar');
        });

        $this->assertSame([
            'common' => 'common',
            'id' => 'web',
            'basePath' => 'basePath',
            'local' => 'bar',
            'components' => [
                'custom' => [
                    'class' => 'bar'
                ]
            ]
        ], $config->toArray(['customname', Config::ENV_LOCAL]));

        $this->assertSame([
            'common' => 'common',
            'id' => 'web',
            'basePath' => 'basePath',
            'components' => [
                'prod' => [
                    'class' => 'bar'
                ],
                'prod2' => [
                    'class' => 'foo'
                ],
            ]
        ], $config->toArray([Config::ENV_PROD]));
    }

    public function testCallable()
    {
        $config = new Config('web', 'basePath', [
            'common' => 'common'
        ]);

        $this->assertTrue($config->isCliRuntime());
        $config->callback(function (Config $cfg) {
            $cfg->setCliRuntime(false);
        });
        // to array runs the callable
        $config->toArray();

        $this->assertFalse($config->isCliRuntime());

        // use config for prod env
        $config = new Config('web', 'basePath', [
            'common' => 'common'
        ]);

        $this->assertTrue($config->isCliRuntime());
        $config->callback(function (Config $cfg) {
            $cfg->setCliRuntime(false);
        })->env(Config::ENV_PROD);
        // to array runs the callable
        $config->toArray([Config::ENV_DEV]);
        // the callable has no effect sind it only runs in prod
        $this->assertTrue($config->isCliRuntime());
    }

    public function testMergeApplicationLevel()
    {
        $config = new Config('foo', 'bar');
        $config->application(['version' => 1]);
        $config->application(['version' => 2]);

        $this->assertSame([
            'id' => 'foo',
            'basePath' => 'bar',
            'version' => 2,
        ], $config->toArray());
    }

    public function testMergeSameVariable()
    {
        $config = new Config('foo', 'bar', [
            'components' => [
                'composition' => [
                    'hidden' => false,
                    'default' => ['langShortCode' => 'de'],
                    'allowedHosts' => ['*.foo'],
                ],
            ]
        ]);

        $config->env(Config::ENV_LOCAL, function ($config) {
            $config->component('composition', [
                'allowedHosts' => ['dd'],
                'hidden' => true,
            ]);
        });

        $this->assertSame([
            'components' => [
                'composition' => [
                    'hidden' => true,
                    'default' => [
                        'langShortCode' => 'de'
                    ],
                    'allowedHosts' => [
                        0 => '*.foo',
                        1 => 'dd'
                    ],
                ],
            ],
            'id' => 'foo',
            'basePath' => 'bar',
        ], $config->toArray([Config::ENV_LOCAL]));
    }
}
