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
     * String Wildcard Check.
     * 
     * Checks whether a strings starts with the wildcard symbole and compares the string before the wild card symbol *
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
     * See if filter conditions match the given value.
     * 
     * Example filter conditions:
     *
     * + `cms_*` matches everything starting with "cms_".
     * + `cms_*,admin_*` matches booth cms_* and admin_* tables.
     * + `!cms_*` matches all not start with "cms_"
     * + `!cms_*,!admin_*` matches all not starting with "cms_" and not starting with "admin_"
     * + `cms_*,!admin_*` matches all start with "cms_" but not start with "admin_"
     *
     * Only first match is relevant:
     * 
     * + "cms_*,!admin_*,admin_*" include all cms_* tables but exclude all admin_* tables (last match has no effect)
     * + "cms_*,admin_*,!admin_*" include all cms_* and admin_* tables (last match has no effect)
     * 
     * Example using condition string:
     * 
     * ```php
     * filterMatch('hello', 'he*'); // true
     * filterMatch('hello', 'ho,he*'); // true
     * filterMatch('hello', ['ho', 'he*']); // true
     * ```
     *
     * @param $value The value on which the filter conditions should be applied on.
     * @param array|string $filters An array of filter conditions, if a string is given he will be exploded by commas.
     * @param boolean $caseSensitive Whether to match value even when lower/upper case is not correct/same.
     * @return bool Returns true if one of the given filter conditions matches.
     * @since 1.3.0
     */
    public static function filterMatch($value, $conditions, $caseSensitive = true)
    {
        if (is_scalar($conditions)) {
            $conditions = self::explode($conditions, ",", true, true);
        }

        foreach ($conditions as $condition) {
            $isMatch = true;
            // negate
            if (substr($condition, 0, 1) == "!") {
                $isMatch = false;
                $condition = substr($condition, 1);
            }
            if ($caseSensitive) {
                $condition = strtolower($condition);
                $value = strtolower($value);
            }
            if ($condition == $value || self::startsWithWildcard($value, $condition)) {
                return $isMatch;
            }
        }

        return false;
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
     * ```php
     * if (StringHelper::contains('foo', 'the foo bar Bar'')) {
     *    echo "yes!";
     * }
     * ```
     *
     * check if one of the given needles exists:
     *
     * ```php
     * if (StringHelper::contains(['jungle', 'hell0], 'Welcome to the jungle!)) {
     *    echo "yes!";
     * }
     * ```
     *
     * @param string|array $needle The char or word to find in the $haystack. Can be an array to multi find words or char in the string.
     * @param string $haystack The haystack where the $needle string should be looked up. A string or phrase with words.
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
     * @param boolean $caseSensitive Whether the search word in the string even when lower/upper case is not correct.
     * @since 1.0.12
     */
    public static function truncateMiddle($content, $word, $length, $affix = '..', $caseSensitive = false)
    {
        $content = strip_tags($content);
        $array = self::mb_str_split($content);
        $first = mb_strpos($caseSensitive ? $content : mb_strtolower($content), $caseSensitive ? $word : mb_strtolower($word));

        // we could not find any match, therefore use casual truncate method.
        if ($first === false) {
            // as the length value in truncate middle stands for to the left and to the right, we multiple this value with 2
            return self::truncate($content, ($length*2), $affix);
        }

        $last = $first + mb_strlen($word);

        // left and right array chars from word
        $left = array_slice($array, 0, $first, true);
        $right = array_slice($array, $last, null, true);
        $middle = array_splice($array, $first, mb_strlen($word));

        // string before
        $before = (count($left) > $length) ? $affix.implode("", array_slice($left, -$length)) : implode("", $left);
        $after = (count($right) > $length) ? implode("", array_slice($right, 0, $length)) . $affix : implode("", $right);

        return $before . implode("", $middle) . $after;
    }

    /**
     * Highlight a word within a content.
     *
     * Since version 1.0.14 an array of words to highlight is possible.
     *
     * > This function IS NOT case sensitive!
     *
     *
     *
     * @param string $content The content to find the word.
     * @param string $word The word to find within the content.
     * @param string $markup The markup used wrap the word to highlight.
     * @since 1.0.12
     */
    public static function highlightWord($content, $word, $markup = '<b>%s</b>')
    {
        $word = (array) $word;
        $content = strip_tags($content);
        $latest = null;
        foreach ($word as $needle) {
            preg_match_all("/".preg_quote($needle, '/')."+/i", $content, $matches);
            if (is_array($matches[0]) && count($matches[0]) >= 1) {
                foreach ($matches[0] as $match) {
                    // ensure if a word is found twice we don't replace again.
                    if ($latest === $match) {
                        continue;
                    }
                    $content = str_replace($match, sprintf($markup, $match), $content);
                    $latest = $match;
                }
            }
        }

        return $content;
    }

    /**
     * Multibyte-safe str_split funciton.
     *
     * @param string $string The string to split into an array
     * @param integer $length The length of the chars to cut.
     * @since 1.0.12
     * @see https://www.php.net/manual/de/function.str-split.php#115703
     */
    public static function mb_str_split($string, $length = 1)
    {
        return preg_split('/(.{'.$length.'})/us', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    }

    /**
     * Check whether a value is numeric or not.
     * 
     * There are situations where is_numeric does not provide the desried result,
     * like for example `is_numeric('3e30')` would return true, as e can be considered
     * as exponential operator.
     * 
     * Therfore this function checks with regex whether values or 0-9 if strict is enabled,
     * which is default behavior.
     *
     * @param mixed $value The value to check.
     * @param boolean $strict
     * @return boolean
     * @since 1.2.0
     */
    public static function isNummeric($value, $strict = true)
    {
        if (!is_scalar($value)) {
            return false;
        }

        if (is_bool($value)) {
            return false;
        }

        if ($strict) {
            return preg_match('/^[0-9]+$/', $value) == 1 ? true : false;
        }    

        return is_numeric($value);
    }

    /**
     * Templating a string with Variables
     * 
     * The variables should be declared as `{{username}}` while the variables array key should contain `username`.
     * 
     * Usage example:
     * 
     * ```php
     * $content = StringHelper::template('<p>{{ name }}</p>', ['name' => 'John']);
     * 
     * // output: <p>John</p>
     * ```
     * 
     * If a variable is not found, the original curly bracktes will be returned.
     * 
     * @param string $template The template to parse. The template may contain double curly brackets variables.
     * @param array $variables The variables which should be available in the template.
     * @param boolean $removeEmpty Whether variables in double curly brackets should be removed event the have not be assigned by $variables array.
     * @return string
     * @since 1.5.0
     */
    public static function template($template, array $variables = [], $removeEmpty = false)
    {
        preg_match_all("/{{(.*?)}}/", $template, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return $template;
        }

        foreach ($matches as $match) {
            if (array_key_exists(trim($match[1]), $variables)) {
                $template = str_replace($match[0], $variables[trim($match[1])], $template);
            } elseif ($removeEmpty) {
                $template = str_replace($match[0], '', $template);
            }
        }

        return $template;
    }

    /**
     * Convert a text with different seperators to an array.
     * 
     * Its very common to use seperators when working with user input, for example a list of domains seperated by commas. Therefore
     * this function will use common seperators the generate an array from a text string.
     * 
     * Explodes the string by: "Newline", ";", ","
     * 
     * + newline
     * + comma
     * + point comma
     *
     * @param string $text A text which contains a list of items seperated by seperators like commas.
     * @return array
     * @since 1.7.1
     */
    public static function textList($text, array $seperators = [PHP_EOL, "\n", "\r", "\n\r", ";", ","])
    {
        return StringHelper::explode(str_replace($seperators, ';', $text), ";", true, true);
    }
}
