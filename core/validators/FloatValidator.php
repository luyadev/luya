<?php

namespace luya\validators;

use Yii;
use yii\validators\Validator;

/**
 * Float Validator
 *
 * @author Basil Suter <basil@nadar.io>
 * @author Martin Petrasch <martin.petrasch@zephir.ch>
 * @since 1.0.0-beta8
 */
class FloatValidator extends Validator
{
    public $message = '{attribute} must be a float or numeric value.';
    
    /**
     * Validate the value if is_numeric or if not is_float
     * {@inheritDoc}
     * @see \yii\validators\Validator::validateAttribute()
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!is_numeric($value)) {
            if (!is_float($value)) {
                return $model->addError($attribute, Yii::t('yii', $this->message, ['attribute' => $model->getAttributeLabel($attribute)]));
            }
        }
    }
}
