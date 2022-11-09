<?php

namespace luya\validators;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\validators\Validator;

/**
 * Phone Number Validator.
 *
 * Validates a given phone number, and converts into standardized format by default. See {{PhoneNumberValidator::$autoFormat}}
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
     * @var boolean Whether the phone number value should be standardized with formating function and write back to the model. This is usefull
     * in order to have all phone numbers save in the correct format in the database.
     */
    public $autoFormat = true;

    /**
     * @var inter The format which should be taken to auto format the phone number value.
     */
    public $autoFormatFormat = PhoneNumberFormat::E164;

    /**
     * @var string This property will recieved the formated value (the parsed value lets say).
     * @since 2.2.0
     */
    public $formatedValue = null;

    /**
     * @var integer If enabled, the validator will check the type of number. This can be usefull to test for mobile phone numbers.
     *
     * An example to check for mobile phone numbers:
     *
     * ```php
     * 'type' => \libphonenumber\PhoneNumberType::MOBILE
     * ```
     */
    public $type;

    /**
     * {@inheritDoc}
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);

        if ($this->autoFormat) {
            $model->{$attribute} = $this->formatedValue;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function validateValue($value)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $number = $phoneUtil->parse($value, $this->country);

            if (!$number || !$phoneUtil->isValidNumber($number)) {
                return [Yii::t('luya', 'Invalid phone number.'), []];
            }

            if ($this->type !== null && ($phoneUtil->getNumberType($number) !== $this->type)) {
                $typeName = PhoneNumberType::values()[$this->type];
                return [Yii::t('luya', 'The phone number does not match the required type {name}.', ['name' => $typeName]), []];
            }

            // refactor the phone number and store in property for later use
            $this->formatedValue = $phoneUtil->format($number, $this->autoFormatFormat);
        } catch (NumberParseException $exception) {
            return [Yii::t('luya', 'Invalid phone number, ensure it starts with the correct country code.'), []];
        }

        return null;
    }
}
