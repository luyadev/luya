<?php

namespace luyatests\core;

use luya\base\DynamicModel;
use luyatests\LuyaWebTestCase;

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
