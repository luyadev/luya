<?php

namespace luyatests\core\validators;

use luya\validators\FloatValidator;
use luyatests\LuyaWebTestCase;
use yii\base\Model;

class StubModel extends Model
{
    public $value;
}

class FloatValidatorTest extends LuyaWebTestCase
{
    public function testNullValue()
    {
        $model = new StubModel();
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertNotEmpty($model->getErrors());
    }

    public function testArrayValue()
    {
        $model = new StubModel();
        $model->value = ['foo' => 'bar'];
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertNotEmpty($model->getErrors());
    }

    public function testStringValue()
    {
        $model = new StubModel();
        $model->value = 'foobar';
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertNotEmpty($model->getErrors());
        $this->assertSame('Value must be a float or numeric value.', $model->getErrors('value')[0]);
    }

    public function testNumericStringValue()
    {
        $model = new StubModel();
        $model->value = '123';
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertEmpty($model->getErrors());
    }

    public function testNumericStringFloatValue()
    {
        $model = new StubModel();
        $model->value = '123.00';
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertEmpty($model->getErrors());
    }

    public function testNumericValue()
    {
        $model = new StubModel();
        $model->value = 123;
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertEmpty($model->getErrors());
    }

    public function testFloatValue()
    {
        $model = new StubModel();
        $model->value = 123.23;
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertEmpty($model->getErrors());
    }

    public function testZeroFloatValue()
    {
        $model = new StubModel();
        $model->value = 0.23;
        $float = new FloatValidator();
        $float->validateAttribute($model, 'value');
        $this->assertEmpty($model->getErrors());
    }
}
