<?php

namespace luyatests\core\validators;

use libphonenumber\PhoneNumberType;
use luya\validators\PhoneNumberValidator;
use luyatests\LuyaWebTestCase;
use yii\base\Model;

class PhoneNumberValidatorTest extends LuyaWebTestCase
{
    public $correctNumbersWithoutCountryCode = [
        '+41 62 871 12 34' => '+41628711234',
        '+41 062 871 12 34' => '+41628711234',
        '+41 999 871 12 34' => false, // this will fail!
        '0041 062 871 12 34' => false,
        '0041 62 871 12 34' => false,
        '0041628711234' => false,
        '041628711234' => false,
        '0416028711234' => false,
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
            if ($expect === false) {
                $this->assertTrue($model->hasErrors());
            } else {
                $this->assertFalse($model->hasErrors());
                $this->assertSame($expect, $model->value);
            }
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

    public function testTypeCompare()
    {
        $model = new StubModelValidatorPhone();
        $model->value = '+41791234567';

        $validator = new PhoneNumberValidator();
        $validator->country = 'CH';
        $validator->type = PhoneNumberType::FIXED_LINE;
        $validator->validateAttribute($model, 'value');

        $this->assertSame(
            ['value' => [
                'The phone number does not match the required type FIXED_LINE.',
            ]
        ],
            $model->getErrors()
        );
        $this->assertTrue($model->hasErrors());
    }

    public function testStandAloneValidationError()
    {
        $validator = new PhoneNumberValidator(['type' => PhoneNumberType::MOBILE]);
        $validator->validate('123123', $error);
        $this->assertSame('Invalid phone number, ensure it starts with the correct country code.', $error);
    }

    public function testStandAloneValidationSuccess()
    {
        $validator = new PhoneNumberValidator(['type' => PhoneNumberType::MOBILE]);
        $validator->validate('+41791234567', $error);
        $this->assertEmpty($error);
        $this->assertSame('+41791234567', $validator->formatedValue);
    }
}

class StubModelValidatorPhone extends Model
{
    public $value;
}
