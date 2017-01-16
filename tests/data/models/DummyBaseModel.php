<?php

namespace luyatests\data\models;

use yii\base\Model;

class DummyBaseModel extends Model
{
    public $foo = null;
    
    public $bar = null;
    
    public function rules()
    {
        return [
            [['foo', 'bar'], 'safe'],
        ];
    }
}
