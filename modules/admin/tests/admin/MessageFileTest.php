<?php

namespace admintests;

use Yii;
use luya\testsuite\traits\MessageFileCompareTrait;

class MessageFileTest extends AdminTestCase
{
    use MessageFileCompareTrait;
    
    public function testFiles()
    {
        $this->compareMessages(Yii::getAlias('@admin/messages'), 'en');
    }
}
