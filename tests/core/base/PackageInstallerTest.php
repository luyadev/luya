<?php

namespace luyatests\core\base;

use luya\base\PackageInstaller;
use luyatests\LuyaWebTestCase;

class PackageInstallerTest extends LuyaWebTestCase
{
    public function testInstaller()
    {
        $installer = new PackageInstaller([
            'timestamp' => 12345,
            'configs' => [
                'luyadev/luya-module-admin' => [
                    'package' => [
                        'foobar' => 'barfoo',
                    ],
                    'nonexstingstring' => 'content',
                    'nonexistingarray' => ['content1', 'content2'],
                    'blocks' => ['block.php'],
                    'bootstrap' => ['bootstrap.php'],
                ]
            ]
        ]);

        foreach ($installer->getConfigs() as $config) {
            $this->assertSame(['foobar' => 'barfoo'], $config->package);
            $this->assertSame('content', $config->getValue('nonexstingstring'));
            $this->assertSame(null, $config->getValue('THIS_KEY_DOES_NOT_EXISTS'));
            $this->assertSame(['content1', 'content2'], $config->getValue('nonexistingarray'));
            $this->assertSame(['block.php'], $config->blocks);
            $this->assertSame(['bootstrap.php'], $config->bootstrap);

            $this->expectException('yii\base\UnknownPropertyException');
            $config->doesnotexsts;
        }

        $this->assertSame(12345, $installer->getTimestamp());
    }
}
