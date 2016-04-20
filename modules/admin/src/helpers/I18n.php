<?php

namespace admin\helpers;

use Yii;
use yii\helpers\Json;

/**
 * I18n Encode/Decode helper method
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta6
 */
class I18n
{
    /**
     * Encode from PHP to Json
     *
     * @param string|array $field
     * @return string Returns a string
     */
    public static function encode($value)
    {
        return (is_array($value)) ? Json::encode($value) : $value;
    }
    
    /**
     * Decode from Json to PHP
     *
     * @param string|array $field The value to decode (or if alreay is an array already)
     * @param string $onEmptyValue Defines the value if the language could not be found and a value will be returns, this value will be used.
     * 
     * @return array returns an array with decoded field value
     */
    public static function decode($value, $onEmptyValue = '')
    {
        $langShortCode = Yii::$app->adminLanguage->getActiveShortCode();
        $languages = Yii::$app->adminLanguage->getLanguages();
    
        // if its not already unserialized, decode it
        if (!is_array($value) && !empty($value)) {
            try {
                $value = Json::decode($value);
            } catch (InvalidParamException $e) {
                $value = [];
            }
        }
    
        // fall back for not transformed values
        if (!is_array($value)) {
            $value = (array) $value;
        }
    
        // add all not existing languages to the array (for example a language has been added after the database item has been created)
        foreach ($languages as $lang) {
            if (!array_key_exists($lang['short_code'], $value)) {
                $value[$lang['short_code']] = $onEmptyValue;
            }
        }
    
        return $value;
    }
    
    /**
     * Find the corresponding element inside an array for the current active language
     *
     * @param array $fieldValues
     * @return string|unknown
     */
    public static function findCurrent(array $fieldValues)
    {
        $langShortCode = Yii::$app->adminLanguage->getActiveShortCode();
    
        return (array_key_exists($langShortCode, $fieldValues)) ? $fieldValues[$langShortCode] : '';
    }
}