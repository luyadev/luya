<?php

namespace admintests;

use Yii;
use luyatests\data\MessageFileComperatorTrait;

class MessageFileTest extends AdminTestCase
{
    use MessageFileComperatorTrait;
    
    public function testFiles()
    {
        $this->compare(Yii::getAlias('@admin/messages'), 'en');
    }
}
