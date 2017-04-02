<?php

namespace luyatests\core\helpers;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\helpers\ZipHelper;

class ZipHelperTest extends LuyaWebTestCase
{
    public function testZipDir()
    {
        ZipHelper::dir(__DIR__, Yii::getAlias('@runtime/test.zip'));
    }
}
