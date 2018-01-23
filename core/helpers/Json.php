<?php

namespace luya\helpers;

use yii\helpers\BaseJson;

/**
 * Json Helper.
 *
 * Extends the {{yii\helpers\Json}} class by some usefull functions like:
 *
 * + {{luya\helpers\Json::isJson()}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Json extends BaseJson
{
    /**
     * Checks if a string is a json or not.
     *
     * Example values which return true:
     *
     * ```php
     * Json::isJson('{"123":"456"}');
     * Json::isJson('{"123":456}');
     * Json::isJson('[{"123":"456"}]');
     * Json::isJson('[{"123":"456"}]');
     * ```
     *
     * @param mixed $value The value to test if its a json or not.
     * @return boolean Whether the string is a json or not.
     */
    public static function isJson($value)
    {
        if (!is_scalar($value)) {
            return false;
        }
        
        $firstChar = substr($value, 0, 1);
        
        
        if ($firstChar !== '{' && $firstChar !== '[') {
            return false;
        }
        
        $json_check = json_decode($value);
        
        return json_last_error() === JSON_ERROR_NONE;
    }
}
