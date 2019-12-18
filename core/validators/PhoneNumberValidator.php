<?php

namespace luya\validators;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use yii\validators\Validator;

/**
 * Phone Number Validator.
 * 
 * Validates a given phone number, and converts into standarized format by default. See {{PhoneNumberValidator::$autoFormat}}
 * 
 * @see https://github.com/giggsey/libphonenumber-for-php This library is used to parse, format and validate.
 * @author Basil Suter  <basil@nadar.io>
 * @since 1.0.25
 */
class PhoneNumberValidator extends Validator
{
    /**
     * @var string If a phone number does not contain the country prefix (+41 f.e), define a default country format which then defines the 
     * country prefix.
     * 
     * ```php
     * 'country' => 'CH',
     * ```
     */
    public $country;

    /**
     * @var boolean Whether the phone number value should be standarized with formating function and write back to the model. This is usefull
     * in order to have all phone numbers save in the correct format in the database.
     */
    public $autoFormat = true;

    /**
     * @var string The format which should be taken to auto format the phone number value.
     */
    public $autoFormatFormat = PhoneNumberFormat::E164;

    /**
     * {@inheritDoc}
     */
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