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
}
