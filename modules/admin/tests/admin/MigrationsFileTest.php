<?php

namespace admintests;

use Yii;
use luya\testsuite\traits\MessageFileCompareTrait;

class MigrationsFileTestextends AdminTestCase
{
    
    public function testFiles()
    {
        $this->compareMessages(Yii::getAlias('@admin/messages'), 'en');
    }
}
