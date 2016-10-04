<?php

namespace luya\admin\models;

use Yii;

/**
 * ADMIN PROPERTY
 *
 * Base classes for CMS properties which are set by import process.
 *
 * @author nadar
 */
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

    public function createObject($value)
    {
        return static::getObject($this->class_name, $value);
    }
    
    public static function getObject($className, $value = null)
    {
        return Yii::createObject(['class' => $className, 'value' => $value]);
    }
}
