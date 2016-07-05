<?php

namespace luya\validators;

use yii\validators\Validator;

/**
 * Float Validator
 * 
 * @author Basil Suter <basil@nadar.io>
 * @author Martin Petrasch <martin.petrasch@zephir.ch>
 */
class FloatValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!is_numeric($attribute)) {
            if (!is_float($model->$attribute)) {
                return $model->addError($attribute, "Value must be float.");
            }
        }
    }
}