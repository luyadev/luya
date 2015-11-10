<?php

namespace admin\models;

use Yii;

class Property extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_property';
    }

    public function rules()
    {
        return [
            [['module_name', 'var_name'], 'required'],
            [['class_name'], 'safe'],
        ];
    }

    public static function getObject($className, $value = null)
    {
        $object = Yii::createObject(['class' => $className, 'value' => $value]);
        $object->trigger($object::EVENT_BEFORE_FIND);

        return $object;
    }
}
