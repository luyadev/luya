<?php

namespace luya\helpers;

/**
 * Extend the Yii Array Helper class
 *
 * @author Basil Suter <basil@nadar.io>
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
     * @param mixed $val The value for the new key
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
    
    /**
     * Search trough all keys inside of an array, any occurence will return the rest of the array.
     *
     * ```php
     * $data  = [
     *     ['name' => 'Foo Bar', 'id' => 1],
     *     ['name' => 'Bar Baz', 'id' => 2],
     * ];
     * ```
     *
     * Assuming the above array parameter searching for `1` would return:
     *
     * ```php
     * $data  = [
     *     ['name' => 'Foo Bar', 'id' => 1],
     * ];
     * ```
     *
     * Searching for the string `Bar` would return the the orignal array is bar would be found in both.
     *
     * @param array $array The multidimensional array keys.
     * @param string $searchText The text you where search inside the rows.
     * @param boolean $sensitive Whether to use strict sensitive search (true) or case insenstivie search (false).
     * @return array The modified array depending on the search result hits.
     */
    public static function search($array, $searchText, $sensitive = false)
    {
        $function = ($sensitive) ? 'strpos' : 'stripos';
        return array_filter($array, function ($item) use ($searchText, $function) {
            $response = false;
            foreach ($item as $key => $value) {
                if ($response) {
                    continue;
                }
                if ($function($value, "$searchText") !== false) {
                    $response = true;
                }
            }
            return $response;
        });
    }
}
