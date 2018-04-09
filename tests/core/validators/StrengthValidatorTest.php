<?php

namespace luyatests\core\validators;

use luyatests\LuyaWebTestCase;
use yii\base\Model;
use luya\validators\StrengthValidator;
use luya\base\DynamicModel;

class StubLengthModel extends Model
{
    public $value;
}

class StrengthValidatorTest extends LuyaWebTestCase
{
    /**
     * Test a given value inside the strength validator.
     * 
     * @param string $value The value to assign to the model.
     * @return \luya\base\DynamicModel
     */
    private function getValidator($value)
    {
        $validator = new StrengthValidator();
        
        $model = new DynamicModel(['value']);
        $model->value = $value;
        
        $validator->validateAttribute($model, 'value');
        
        return $model;
    }
    
    public function testSpecialChars()
    {
        // fails
        $this->assertTrue($this->getValidator('prefixfoobar')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobar%')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobar4')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobarA')->hasErrors());
        $this->assertTrue($this->getValidator('12319237192837192')->hasErrors());
        $this->assertTrue($this->getValidator('dhfdkjfdlkfjdlfjldkfj')->hasErrors());
        $this->assertTrue($this->getValidator('ööööööööööööö()()()/)/)')->hasErrors());
        
        // success
        $this->assertFalse($this->getValidator('fOobar%1B')->hasErrors());
    }
}
