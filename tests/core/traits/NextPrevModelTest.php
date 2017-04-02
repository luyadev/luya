<?php

namespace luyatests\core\traits;

use luyatests\LuyaWebTestCase;
use luyatests\data\models\AdminAuthModel;
use luya\traits\NextPrevModel;

class StubModel extends AdminAuthModel
{
    use NextPrevModel;
}

class NextPrevModelTest extends LuyaWebTestCase
{
    public function testNext()
    {
        $model = StubModel::findOne(1);
        
        $this->assertNotFalse($model);
        
        $this->assertNull($model->getPrev());
        $this->assertNotNull($model->getNext());
    }
    
    public function testPrev()
    {
        $model = StubModel::findOne(2);
    
        $this->assertNotFalse($model);
    
        $this->assertNotNull($model->getPrev());
        $this->assertNotNull($model->getNext());
    }
}
