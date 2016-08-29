<?php

namespace luya\helpers;

/**
 * Extend the Yii Array Helper class
 *
 * @author nadar
 */
class ArrayHelper extends \yii\helpers\BaseArrayHelper
{
    /**
     * Create an object from an array.
     *
     * @param array $array
     * @return object
     */
    public static function toObject(array $array)
    {
        return json_decode(json_encode($array), false);
    }

    /**
     * Prepend an assoc array item as first entry for a given array.
     *
     * @param array $arr The array where the value should be prepend
     * @param string $key The new array key
     * @param mix $val The value for the new key
     * @return array
     */
    public static function arrayUnshiftAssoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        return array_reverse($arr, true);
    }
    
    /**
     * TypeCast values from a mixed array source. numeric values will be casted as integer.
     *
     * This method is often used to convert corect json respons arrays
     *
     * @param array $array The array which should be type casted
     * @return array An array with type casted values
     */
    public static function typeCast($array)
    {
        $return = [];
        
        foreach ($array as $k => $v) {
            if (is_numeric($v)) {
                if (is_float($v)) {
                    $return[$k] = (float)$v;
                } else {
                    $return[$k] = (int)$v;
                }
            } elseif (is_array($v)) {
                $return[$k] = self::typeCast($v);
            } else {
                $return[$k] = $v;
            }
        }
        
        return $return;
    }
}
