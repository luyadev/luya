<?php

namespace luya\helpers;

use yii\helpers\BaseStringHelper;

/**
 * Helper methods when dealing with Strings.
 *
 * Extends the {{yii\helpers\StringHelper}} class by some usefull functions like:
 *
 * + {{luya\helpers\StringHelper::typeCast()}}
 * + {{luya\helpers\StringHelper::isFloat()}}
 * + {{luya\helpers\StringHelper::replaceFirst()}}
 * + {{luya\helpers\StringHelper::contains()}}
 * + {{luya\helpers\StringHelper::startsWithWildcard()}}
 * + {{luya\helpers\StringHelper::typeCastNumeric()}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class StringHelper extends BaseStringHelper
{
    /**
     * TypeCast a string to its specific types.
     *
     * Arrays will passed to to the {{luya\helpers\ArrayHelper::typeCast()}} class.
     *
     * @param mixed $string The input string to type cast. Arrays will be passted to {{luya\helpers\ArrayHelper::typeCast()}}.
     * @return mixed The new type casted value, if the input is an array the output is the typecasted array.
     */
    public static function typeCast($string)
    {
        if (is_numeric($string)) {
            return static::typeCastNumeric($string);
        } elseif (is_array($string)) {
            return ArrayHelper::typeCast($string);
        }
        
        return $string;
    }
    
    /**
     * Checke whether a strings starts with the wildcard symbole and compares the string before the wild card symbol *
     * with the string provided, if there is NO wildcard symbold it always return false.
     *
     *
     * @param string $string The string which should be checked with $with comperator
     * @param string $with The with string which must end with the wildcard symbol * e.g. `foo*` would match string `foobar`.
     * @param boolean $caseSensitive Whether to compare the starts with string as case sensitive or not, defaults to true.
     * @return boolean Whether the string starts with the wildcard marked string or not, if no wildcard symbol is contained.
     * in the $with it always returns false.
     */
    public static function startsWithWildcard($string, $with, $caseSensitive = true)
    {
        if (substr($with, -1) != "*") {
            return false;
        }
        
        return self::startsWith($string, rtrim($with, '*'), $caseSensitive);
    }
    
    /**
     * TypeCast a numeric value to float or integer.
     *
     * If the given value is not a numeric or float value it will be returned as it is. In order to find out whether its float
     * or not use {{luya\helpers\StringHelper::isFloat()}}.
     *
     * @param mixed $value The given value to parse.
     * @return mixed Returns the original value if not numeric or integer, float casted value.
     */
    public static function typeCastNumeric($value)
    {
        if (!self::isFloat($value)) {
            return $value;
        }
        
        if (intval($value) == $value) {
            return (int) $value;
        }
        
        return (float) $value;
    }
    
    /**
     * Checks whether a string is a float value.
     *
     * Compared to `is_float` function of php, it only ensures whether the input variable is type float.
     *
     * @param mixed $value The value to check whether its float or not.
     * @return boolean Whether its a float value or not.
     */
    public static function isFloat($value)
    {
        if (is_float($value)) {
            return true;
        }
        
        return ($value == (string)(float) $value);
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
     * @return boolean If an array of values is provided the response may change depending on $findAll.
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
    
    /**
     * "Minify" html content.
     *
     * + remove space
     * + remove tabs
     * + remove newlines
     * + remove html comments
     *
     * @param string $content The content to minify.
     * @param array $options Optional arguments to provide for minification:
     * - comments: boolean, where html comments should be removed or not. defaults to false
     * @return mixed Returns the minified content.
     * @since 1.0.7
     */
    public static function minify($content, array $options = [])
    {
        $min = preg_replace(['/[\n\r]/', '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', ], ['', '>', '<', '\\1'], trim($content));
        $min = str_replace(['> <'], ['><'], $min);
        
        if (ArrayHelper::getValue($options, 'comments', false)) {
            $min = preg_replace('/<!--(.*)-->/Uis', '', $min);
        }
        
        return $min;
    }

    /**
     * Cut the given word/string from the content. Its truncates to the left side and to the right side of the word.
     *
     * An example of how a sentenced is cut:
     *
     * ```php
     * $cut = StringHelper::truncateMiddle('the quick fox jumped over the lazy dog', 'jumped', 12);
     * echo $cut; // ..e quick fox jumped over the la..
     * ```
     *
     * @param string $content The content to cut the words from.
     * @param string $word The word which should be in the middle of the string
     * @param integer $length The amount of the chars to cut on the left and right side from the word.
     * @param string $affix The chars which should be used for prefix and suffix when string is cuted.
     * @since 1.0.12
     */
    public static function truncateMiddle($content, $word, $length, $affix = '..')
    {
        $content = strip_tags($content);
        $array = self::mb_str_split($content);
        $first = mb_strpos($content, $word);
        $last = $first + mb_strlen($word);

        // left and right array chars from word
        $left = array_slice($array, 0, $first, true);
        $right = array_slice($array, $last, null, true);

        // string before
        $before = (count($left) > $length) ? $affix.implode("", array_slice($left, -$length)) : implode("", $left);
        $after = (count($right) > $length) ? implode("", array_slice($right, 0, $length)) . $affix : implode("", $right);

        return $before . $word . $after;
    }

    /**
     * Highlight a word within a content.
     *
     * @param string $content The content to find the word.
     * @param string $word The word to find within the content.
     * @param string $markup The markup used wrap the word to highlight.
     * @since 1.0.12
     */
    public static function highlightWord($content, $word, $markup = '<b>%s</b>')
    {
        return str_replace($word, sprintf($markup, $word), strip_tags($content));
    }

    /**
     * Multibyte-safe str_split funciton.
     *
     * @param string $string The string to split into an array
     * @param integer $length The length of the chars to cut.
     * @since 1.0.12
     */
    public static function mb_str_split($string, $length = 1)
    {
        $array = [];
        $stringLength = mb_strlen($string, 'UTF-8');
    
        for ($i = 0; $i < $stringLength; $i += $length) {
            $array[] = mb_substr($string, $i, $length, 'UTF-8');
        }
    
        return $array;
    }
}
