<?php

namespace luya\helpers;

use yii\helpers\BaseArrayHelper;

/**
 * Helper methods when dealing with Arrays.
 *
 * Extends the {{yii\helpers\ArrayHelper}} class by some usefull functions like:
 *
 * + {{luya\helpers\ArrayHelper::toObject()}}
 * + {{luya\helpers\ArrayHelper::arrayUnshiftAssoc()}}
 * + {{luya\helpers\ArrayHelper::typeCast()}}
 * + {{luya\helpers\ArrayHelper::search()}}
 * + {{luya\helpers\ArrayHelper::searchColumn()}}
 * + {{luya\helpers\ArrayHelper::searchColumns()}}
 * + {{luya\helpers\ArrayHelper::generateRange()}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ArrayHelper extends BaseArrayHelper
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
     * Cover senstive values from a given list of keys.
     *
     * The main purpose is to remove passwords transferd to api when existing in post, get or session.
     * 
     * Example:
     * 
     * ```php
     * $data = ArrayHelper::coverSensitiveValues(['username' => 'foo', 'password' => 'bar'], ['password']];
     * 
     * var_dump($data); // array('username' => 'foo', 'password' => '***');
     * ```
     *
     * @param array $data The input data to cover given sensitive key values. `['username' => 'foo', 'password' => 'bar']`.
     * @param array $key The keys which can contain sensitive data inside the $data array. `['password', 'pwd', 'pass']`.
     * @since 1.0.6
     */
    public static function coverSensitiveValues(array $data, array $keys)
    {
        $clean = [];
        foreach ($keys as $key) {
            $kw = strtolower($key);
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $clean[$k] = static::coverSensitiveValues($v, $keys);
                } elseif (is_scalar($v) && ($kw == strtolower($k) || StringHelper::startsWith(strtolower($k), $kw))) {
                    $v = str_repeat("*", strlen($v));
                    $clean[$k] = $v;
                }
            }
        }
        
        // the later overrides the former
        return array_replace($data, $clean);
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
     * Compare to searchColumns() this function return will return the first found result.
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
     * > This will not work with assoc keys
     *
     * @param array $array The array with the multimensional array values.
     * @param string $column The column to lookup and compare with the $search string.
     * @param string $search The string to search inside the provided column.
     * @return array|boolean
     */
    public static function searchColumn(array $array, $column, $search)
    {
        $columns = array_column($array, $column);
        $key = array_search($search, $columns);
        return ($key !== false) ?  $array[$key] : false;
    }
    
    /**
     * Search for columns with the given search value, returns the full array with all valid items.
     *
     * Compare to searchColumn() this function return will return all found results.
     *
     * > This function is not casesensitive, which means FOO will match Foo, foo and FOO
     *
     * ```php
     * $array = [
     *     ['name' => 'luya', 'userId' => 1],
     *     ['name' => 'nadar', 'userId' => 1],
     * ];
     *
     * $result = ArrayHelper::searchColumns($array, 'userId', '1');
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
        $keys = array_filter($array, function ($var) use ($column, $search) {
            return strcasecmp($search, $var[$column]) == 0 ? true : false;
        });
        
        return $keys;
    }
    
    /**
     * Generate an Array from a Rang with an appending optional Text.
     *
     * This is commonly used when generate dropDowns in forms to select a number of something.
     *
     * When $text is an array, the first key is the singular value to use, the second is the pluralized value.
     *
     * ```php
     * $range = ArrayHelper::generateRange(1, 3, 'ticket');
     * // array (1 => "1 ticket", 2 => "2 ticket", 3 => "3 ticket")
     * ```
     *
     * Using the pluralized texts:
     *
     * ```php
     * $range = ArrayHelper::generateRange(1, 3, ['ticket', 'tickets']);
     * // array (1 => "1 ticket", 2 => "2 tickets", 3 => "3 tickets")
     * ```
     *
     * In php range() function is used to generate the array range.
     *
     * @param string|integer $from The range starts from
     * @param string|integer $to The range ends
     * @param string|array $text Optinal text to append to each element. If an array is given the first value is used
     * for the singular value, the second will be used for the pluralized values.
     * @return array An array where the key is the number and value the number with optional text.
     */
    public static function generateRange($from, $to, $text = null)
    {
        $range = range($from, $to);
        $array = array_combine($range, $range);
        
        if ($text) {
            array_walk($array, function (&$item, $key) use ($text) {
                if (is_array($text)) {
                    list($singular, $plural) = $text;
                    if ($key == 1) {
                        $item = "{$key} {$singular}";
                    } else {
                        $item = "{$key} {$plural}";
                    }
                } else {
                    $item = "{$key} {$text}";
                }
            });
        }
        
        return $array;
    }
}
