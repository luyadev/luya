<?php

namespace cmstests\src;

use Yii;
use luyatests\data\MessageFileComperatorTrait;
use cmstests\CmsFrontendTestCase;

class MessageFileTest extends CmsFrontendTestCase
{
    use MessageFileComperatorTrait;

    public function testAdminMessages()
    {
        $this->compare(Yii::getAlias('@cmsadmin/messages'), 'en');
    }
    
    public function testFrontendMessages()
    {
        $this->compare(Yii::getAlias('@cms/messages'), 'en');
    }
}
