<?php

namespace luya\helpers;

/**
 * Helper methods when dealing with Strings.
 *
 * Extends the {{yii\helpers\StringHelper}} class by some usefull functions like:
 *
 * + {{luya\helpers\StringHelper::typeCast}}
 * + {{luya\helpers\StringHelper::replaceFirst}}
 * + {{luya\helpers\StringHelper::contains}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class StringHelper extends \yii\helpers\BaseStringHelper
{
    /**
     * TypeCast a string to its specific types.
     *
     * Arrays will passed to to the {{luya\helpers\ArrayHelper::typeCast}} class.
     *
     * @param mixed $string The input string to type cast. Arrays will be passted to {{luya\helpers\ArrayHelper::typeCast}}.
     * @return mixed The new type casted value, if the input is an array the output is the typecasted array.
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
    
    /**
     * Replace only the first occurance found inside the string.
     *
     * The replace first method is *case sensitive*.
     *
     * ```php
     * StringHelper::replaceFirst('abc', '123', 'abc abc abc'); // returns "123 abc abc"
     * ```
     *
     * @param string $search Search string to look for.
     * @param string $replace Replacement value for the first found occurrence.
     * @param string $subject The string you want to look up to replace the first element.
     * @return mixed Replaced string
     * @since 1.0.0-rc1
     */
    public static function replaceFirst($search, $replace, $subject)
    {
        return preg_replace('/'.preg_quote($search, '/').'/', $replace, $subject, 1);
    }
    
    /**
     * Check whether a char or word exists in a string or not.
     *
     * This method is case sensitive. The need can be an array with multiple chars or words who
     * are going to look up in the haystack string.
     *
     * If an array of needle words is provided the $strict parameter defines whether all need keys must be found
     * in the string to get the `true` response or if just one of the keys are found the response is already `true`.
     *
     * @param string|array $needle The char or word to find in the $haystack. Can be an array to multi find words or char in the string.
     * @param string $haystack The haystack where the $needle string should be looked  up.
     * @param boolean $strict If an array of needles is provided the $strict parameter defines whether all keys must be found ($strict = true) or just one result must be found ($strict = false).
     * @return boolean If an array of values is provided the response may change depending on $findAll
     * @since 1.0.0-rc1
     */
    public static function contains($needle, $haystack, $strict = false)
    {
        $needles = (array) $needle;
        
        $state = false;
        
        foreach ($needles as $item) {
            $state = (strpos($haystack, $item) !== false);
            
            if ($strict && !$state) {
                return false;
            }
            
            if (!$strict && $state) {
                return true;
            }
        }

        return $state;
    }
}
