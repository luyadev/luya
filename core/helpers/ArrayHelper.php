<?php

namespace luya\helpers;

/**
 * Helper methods when dealing with Arrays.
 *
 * Extends the {{yii\helpers\ArrayHelper}} class by some usefull functions like:
 *
 * + {{luya\helpers\ArrayHelper::toObject}}
 * + {{luya\helpers\ArrayHelper::arrayUnshiftAssoc}}
 * + {{luya\helpers\ArrayHelper::typeCast}}
 * + {{luya\helpers\ArrayHelper::search}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
    public static function typeCast(array $array)
    {
        $return = [];
        
        foreach ($array as $k => $v) {
            if (is_numeric($v)) {
                $return[$k] = StringHelper::typeCastNumeric($v);
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
    public static function search(array $array, $searchText, $sensitive = false)
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
    
    /**
     * Search for a Column Value inside a Multidimension array and return the array with the found key.
     * 
     * If several results with the same key value exists, the first result is picked.
     * 
     * ```php
     * $array = [
     *     ['name' => 'luya', 'userId' => 1],
     *     ['name' => 'nadar', 'userId' => 2],
     * ];
     * 
     * $result = ArrayHelper::searchColumn($array, 'name', 'nadar');
     * 
     * // output:
     * // array ('name' => 'nadar', 'userId' => 2);
     * ```
     * 
     * @param array $array The array with the multimensional array values.
     * @param string $column The column to lookup and compare with the $search string.
     * @param string $search The string to search inside the provided column.
     * @return array|boolean
     */
    public static function searchColumn(array $array, $column, $search)
    {
        $key = array_search($search, array_column($array, $column));
        
        return ($key !== false) ?  $array[$key] : false;
    }
    
    /**
     * Search for columns with the given search value, returns the full array with all valid items.
     * 
     * > This function is not casesensitive, which means FOO will match Foo, foo and FOO
     * 
     * ```php
     * $array = [
     *     ['name' => 'luya', 'userId' => 1],
     *     ['name' => 'nadar', 'userId' => 1],
     * ];
     * 
     * $result = ArrayHelper::searchColumn($array, 'userId', '1');
     * 
     * // output:
     * // array (
     * //     array ('name' => 'luya', 'userId' => 1),
     * //     array ('name' => 'nadar', 'userId' => 1)
     * // );
     * ```
     * 
     * @param array $array The multidimensional array input
     * @param string $column The column to compare with $search string
     * @param mixed $search The search string to compare with the column value.
     * @return array Returns an array with all valid elements.
     */
    public static function searchColumns(array $array, $column, $search)
    {
        $keys = array_filter($array, function($var) use($column, $search) {
            return strcasecmp($search, $var[$column]) == 0 ? true : false;
        });
        
        return $keys;
    }
}
