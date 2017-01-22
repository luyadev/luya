<?php

namespace luyatests\core;

use luyatests\LuyaWebTestCase;
use luyatests\data\models\DummyBaseModel;
use luya\base\DynamicModel;

class StubTestModel extends DynamicModel
{
}

class DynamicModelTest extends LuyaWebTestCase
{
    public function testAttributeLabels()
    {
        $model = new StubTestModel();
        $model->attributeLabels = [
            'foo' => 'Foo Label',
            'bar' => 'Bar Label',
        ];
        
        $atr = $model->attributeLabels();
        
        $this->assertArrayHasKey('foo', $atr);
        $this->assertArrayHasKey('bar', $atr);
        $this->assertSame('Foo Label', $atr['foo']);
    }
}
