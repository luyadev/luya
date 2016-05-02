<?php

namespace luya\helpers;

/**
 * String Helper additional to Yii base String Helper
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta7
 */
class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * TypeCast a string to its specific type, arrays will passed to arrayhelper::typeCast method.
     * 
     * @param mixed $string The input string to typecase
     * @return mixed The typecased value
     */
    public static function typeCast($string)
    {
        if (is_numeric($string)) {
            if (is_float($string)) {
                return (float)$string;
            } else {
                return (int)$string;
            }
        } elseif (is_array($string)) {
            return ArrayHelper::typeCast($string);
        }
        
        return $string;
    }
}