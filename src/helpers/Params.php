<?php
namespace luya\helpers;

use Yii;

class Params
{
    /**
     * Get yii parameter.
     *
     * @param string $param
     *
     * @return array
     */
    public static function get($param, $default = [])
    {
        return (isset(yii::$app->params[$param])) ? yii::$app->params[$param] : $default;
    }
    
    /**
     * Set new yii parameter.
     *
     * @param string $param
     * @param array  $value
     */
    public static function set($param, $value)
    {
        yii::$app->params[$param] = $value;
    }
}