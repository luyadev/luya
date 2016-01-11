<?php

namespace luya\helpers;

class ArrayHelper extends \yii\helpers\BaseArrayHelper
{
    public static function toObject(array $array)
    {
        return json_decode(json_encode($array), false);
    }

    public static function arrayUnshiftAssoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;

        return array_reverse($arr, true);
    }
    
    /**
     * cast an array into their respectiv types 
     * 
     * @param unknown $array
     * @return multitype:number unknown multitype:number NULL unknown
     */
    public static function typeCast($array)
    {
        $return = [];
        
        foreach ($array as $k => $v) {
            if (is_numeric($v)) {
                $return[$k] = (int)$v;
            } elseif (is_array($v)) {
                $return[$k] = self::typeCast($v);
            } else {
                $return[$k] = $v;
            }
        }
        
        return $return;
    }
}
