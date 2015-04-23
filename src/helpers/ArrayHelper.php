<?php
namespace luya\helpers;

class ArrayHelper extends \yii\helpers\BaseArrayHelper
{
    public static function toObject(array $array)
    {
        return json_decode(json_encode($array), FALSE);
    }
}