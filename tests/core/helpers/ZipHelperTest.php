<?php

namespace luyatests\core\helpers;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\helpers\ZipHelper;

class ZipHelperTest extends LuyaWebTestCase
{
    public function testZipDir()
    {
        $this->assertTrue(ZipHelper::dir(__DIR__, Yii::getAlias('@runtime/test.zip')));
        $this->assertTrue(is_file(Yii::getAlias('@runtime/test.zip')));
    }
}
