<?php

namespace luyatests\data\models;

use yii\base\Model;

class DummyBaseModel extends Model
{
    public $foo;

    public $bar;

    public function rules()
    {
        return [
            [['foo', 'bar'], 'safe'],
        ];
    }
}
