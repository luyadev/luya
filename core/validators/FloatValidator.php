<?php

namespace luya\validators;

use Yii;
use yii\validators\Validator;

/**
 * Float Validator.
 *
 * A validation rule to verify whether a value is a float or numeric value.
 *
 * ```php
 * public function rules()
 * {
 *     return [
 *         [['price', 'weight'], \luya\validators\FloatValidator::class],
 *     ]
 * }
 * ```
 *
 * The following values are valid:
 *
 * + `'123'`
 * + `'123.00'`
 * + `123`
 * + `123.00`
 * + `0.10`
 *
 * @author Basil Suter <basil@nadar.io>
 * @author Martin Petrasch <martin.petrasch@zephir.ch>
 * @since 1.0.0
 */
class FloatValidator extends Validator
{
    /**
     * @var string The messaged to send when an error appears.
     */
    public $message = '{attribute} must be a float or numeric value.';
    
    /**
     * Validate the value if is_numeric or if not is_float.
     *
     * @see \yii\validators\Validator::validateAttribute()
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!is_numeric($value) && !is_float($value)) {
            return $model->addError($attribute, Yii::t('luya', $this->message, ['attribute' => $model->getAttributeLabel($attribute)]));
        }
    }
}
