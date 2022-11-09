<?php

namespace luyatests\core\validators;

use luya\base\DynamicModel;
use luya\validators\StrengthValidator;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\base\Model;

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
        $this->assertTrue($this->getValidator('a')->hasErrors());
        $this->assertTrue($this->getValidator('!!!!!!!!!!!!!!!09090909090!!!!')->hasErrors());
        $this->assertTrue($this->getValidator('!!!!!!!!!00003434000000ZTZTZTZTZ')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobar')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobar%')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobar4')->hasErrors());
        $this->assertTrue($this->getValidator('smallchars2018?`!')->hasErrors());
        $this->assertTrue($this->getValidator('prefixfoobarA')->hasErrors());
        $this->assertTrue($this->getValidator('12319237192837192')->hasErrors());
        $this->assertTrue($this->getValidator('dhfdkjfdlkfjdlfjldkfj')->hasErrors());
        $this->assertTrue($this->getValidator('ööööööööööööö()()()/)/)')->hasErrors());

        // success
        $this->assertFalse($this->getValidator('fOobar%1B')->hasErrors());
        $this->assertFalse($this->getValidator('12345!Ba')->hasErrors());
    }

    public function testValidatorTranslationError()
    {
        Yii::$app->language = 'de';
        $this->assertSame(['value' => ['Value muss mindestens über 8 Zeichen verfügen.']], $this->getValidator('a')->getErrors());
    }
}
