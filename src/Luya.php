<?php
namespace luya;

use yii;

/**
 * Luya
 * 
 * Provides basic functionality to wrap yii functions and make life more easy.
 */
final class Luya
{
    /**
     * Get yii parameter
     * 
     * @param string $param
     * @return array
     */
    public static function getParams($param)
    {
        return (isset(yii::$app->params[$param])) ? yii::$app->params[$param] : [];
    }
    
    /**
     * Set new yii parameter
     * 
     * @param string $param
     * @param array $value
     */
    public static function setParams($param, $value)
    {
        yii::$app->params[$param] = $value;
    }
}