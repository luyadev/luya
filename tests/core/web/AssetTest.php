<?php

namespace luyatests\core\web;

use luya\web\Asset;
use luyatests\LuyaWebTestCase;

class AssetTest extends LuyaWebTestCase
{
    public function testDefaultSourcePath()
    {
        $this->assertStringContainsString('core/web/resources/asset', (new Asset())->sourcePath);
        $this->assertStringContainsString('core/web/resources/my-super-asset', (new MySuperAsset())->sourcePath);
    }
}

class MySuperAsset extends Asset
{
}
