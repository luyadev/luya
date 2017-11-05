<?php

namespace luya\admin\helpers;

use Yii;
use yii\helpers\Json;
use yii\base\InvalidParamException;

/**
 * I18n Encode/Decode helper method
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class I18n
{
    /**
     * Encode from PHP to Json
     *
     * @param string|array $value The value to encode from php to json.
     * @return string Returns the json encoded string.
     */
    public static function encode($value)
    {
        return (is_array($value)) ? Json::encode($value) : $value;
    }
    
    /**
     * Decode from Json to PHP
     *
     * @param string|array $value The value to decode from json to php.
     * @param string $onEmptyValue Defines the value if the language could not be found and a value will be returns, this value will be used.
     * @return array Return the decoded php value.
     */
    public static function decode($value, $onEmptyValue = '')
    {
        $languages = Yii::$app->adminLanguage->getLanguages();
    
        // if its not already unserialized, decode it
        if (!is_array($value) && !empty($value)) {
            try {
                $value = Json::decode($value);
            } catch (InvalidParamException $e) {
                $value = [];
            }
        }
    
        // if value is empty, we create an empty array
        if (empty($value)) {
            $value = [];
        }
        
        // fall back for not transformed values
        if (!is_array($value)) {
            $value = (array) $value;
        }
    
        // add all not existing languages to the array (for example a language has been added after the database item has been created)
        foreach ($languages as $lang) {
            if (!array_key_exists($lang['short_code'], $value)) {
                $value[$lang['short_code']] = $onEmptyValue;
            } elseif (empty($value[$lang['short_code']])) {
                $value[$lang['short_code']] = $onEmptyValue;
            }
        }
    
        return $value;
    }

    /**
     * Decode an arry with i18n values.
     *
     * In order to decode an arry with json values you can use this function istead of iterator trough
     * the array items by yourself and calling {{luya\admin\helpers\I18n::decode}}.
     *
     * ```php
     * $array = ['{"de:"Hallo","en":"Hello"}', '{"de:"Ja","en":"Yes"}'];
     *
     * $decoded = I18n::decodeArray($array);
     *
     * print_r($decoded); // Dumps: [0 => ['de' => 'Hallo', 'en' => 'Hello'], 1 => ['de' => 'Ja', 'en' => 'Yes']]; if default language is English.
     * ```
     *
     * @param array $array The array to iterator trough and call the {{luya\admin\helpers\I18n::decode}} on its value.
     * @param string $onEmptyValue If the decoded value is not existing or empty, this default value will be used instead of null.
     * @return array
     */
    public static function decodeArray(array $array, $onEmptyValue = '')
    {
        $decoded = [];
        foreach ($array as $key => $value) {
            $decoded[$key] = static::decode($value, $onEmptyValue);
        }
        
        return $decoded;
    }
    
    /**
     * Find the corresponding element inside an array for the current active language.
     *
     * ```php
     * // assume the default language is `en`
     * $output = I18n::findActive(['de' => 'Hallo', 'en' => 'Hello']);
     * echo $output; // output is "Hello"
     * ```
     *
     * @param array $fieldValues The array you want to to find the current
     * @param mixed $onEmptyValue The value you can set when the language could not be found
     * @return mixed
     */
    public static function findActive(array $fieldValues, $onEmptyValue = '')
    {
        $langShortCode = Yii::$app->adminLanguage->getActiveShortCode();
    
        return (array_key_exists($langShortCode, $fieldValues)) ? $fieldValues[$langShortCode] : $onEmptyValue;
    }

    /**
     * Find the corresponding element inside an array for the current active language
     *
     * @param array $fieldValues The array you want to to find the current
     * @param mixed $onEmptyValue The value you can set when the language could not be found
     * @return array
     */
    public static function findActiveArray(array $array, $onEmptyValue = '')
    {
        $output = [];
        foreach ($array as $key => $value) {
            $output[$key] = static::findActive($value, $onEmptyValue);
        }
        
        return $output;
    }
    
    /**
     * Decodes a json string and returns the current active language item.
     *
     * ```php
     * // assume the default language is `en`
     * $output = I18n::decodeActive('{"de":"Hallo","en":"Hello"}');
     * echo $output; // output is "Hello"
     * ```
     *
     * @param string $input The json string
     * @param string $onEmptyValue If element is not found, this value is returned instead.
     * @return string The value from the json for the current active language or if not found the value from onEmptyValue.
     */
    public static function decodeActive($input, $onEmptyValue = '')
    {
        return static::findActive(static::decode($input, $onEmptyValue));
    }
    
    /**
     * Decodes an array with json strings and returns the current active language item for each entry.
     *
     * @param array $input
     * @param mixed $onEmptyValue
     * @return array
     */
    public static function decodeActiveArray(array $input, $onEmptyValue = '')
    {
        return static::findActiveArray(static::decodeArray($input, $onEmptyValue));
    }
}
