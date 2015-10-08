<?php

namespace admin\models;

use Yii;

class Property extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_FIND, [$this, 'unserialize']);
    }
    
    public static function tableName()
    {
        return 'admin_property';
    }
    
    public function rules()
    {
        return [
            [['module_name', 'var_name', 'type', 'label'], 'required'],
            [['option_json', 'default_value', 'class_name'], 'safe'],
        ];
    }
    
    public function unserialize()
    {
        $this->option_json = json_decode($this->option_json, true);
    }
    
    public static function getObject($className, $value)
    {
        return Yii::createObject(['class' => $className, 'value' => $value]);
    }
}