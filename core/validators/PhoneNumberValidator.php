<?php

namespace luya\validators;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use yii\validators\Validator;

/**
 * Phone Number Validator.
 * 
 * @author Basil Suter  <basil@nadar.io>
 * @since 1.0.25
 */
class PhoneNumberValidator extends Validator
{
    public $country;

    public $autoFormat = true;

    public $autoFormatFormat = PhoneNumberFormat::E164;

    public function validateAttribute($model, $attribute)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $value = $model->{$attribute};

        try {
            $number = $phoneUtil->parse($value, $this->country);

            if (!$phoneUtil->isValidNumber($number)) {
                return $this->addError($model, $attribute, 'The given number is invalid.');
            }

            // refactor the phone number
            if ($number && $this->autoFormat) {
                $model->{$attribute} = $phoneUtil->format($number, $this->autoFormatFormat);
            }

        } catch (NumberParseException $exception) {
            $this->addError($model, $attribute, 'Invalid Phone Number, ensure the correct country code is available.');
        }
    }
}