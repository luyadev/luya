<?php

namespace luyatests\core\validators;

use luya\validators\PhoneNumberValidator;
use luyatests\LuyaWebTestCase;
use yii\base\Model;

class PhoneNumberValidatorTest extends LuyaWebTestCase
{
    public $correctNumbersWithoutCountryCode = [
        '+41 62 871 12 34' => '+41628711234',
        '+41 062 871 12 34' => '+41628711234',
    ];

    public $correctNumbersWithCountryCode = [
        '062 871 12 34' => ['country' => 'CH', 'expect' => '+41628711234'],
        '62 871 12 36' => ['country' => 'CH', 'expect' => '+41628711236'],
        '0041 062 871 12 35' => ['country' => 'CH', 'expect' => '+41628711235'],
    ];

    public function testWrongFormat()
    {
        $model = new StubModelValidatorPhone();
        $validator = new PhoneNumberValidator();
        $validator->validateAttribute($model, 'value');
        $this->assertTrue($model->hasErrors());
    }

    public function testWrongFormatButNumber()
    {
        $model = new StubModelValidatorPhone();
        $model->value = '0628711234';
        $validator = new PhoneNumberValidator();
        $validator->validateAttribute($model, 'value');
        $this->assertTrue($model->hasErrors());
    }

    public function testCorrectNumberWithOutCountryCode()
    {
        foreach ($this->correctNumbersWithoutCountryCode as $number => $expect) {

            $model = new StubModelValidatorPhone();
            $model->value = $number;
            $validator = new PhoneNumberValidator();
            $validator->validateAttribute($model, 'value');
            $this->assertFalse($model->hasErrors());
            $this->assertSame($expect, $model->value);
        }
    }

    public function testCorrectNumberWithCountryCode()
    {
        foreach ($this->correctNumbersWithCountryCode as $number => $expect) {

            $model = new StubModelValidatorPhone();
            $model->value = $number;
            $validator = new PhoneNumberValidator();
            $validator->country = $expect['country'];
            $validator->validateAttribute($model, 'value');
            $this->assertFalse($model->hasErrors());
            $this->assertSame($expect['expect'], $model->value);
        }
    }
}

class StubModelValidatorPhone extends Model
{
    public $value;
}
