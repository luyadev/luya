<?php

namespace admin\storage;

use Yii;

trait ItemTrait
{
    public $itemArray = [];

    public static function create(array $itemArray)
    {
        return Yii::createObject(['class' => self::className(), 'itemArray' => $itemArray]);
    }
    
    abstract public function toArray();
}
