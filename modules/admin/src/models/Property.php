<?php

namespace luya\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * ADMIN PROPERTY
 *
 * Base classes for CMS properties which are set by import process.
 *
 * @property integer $id
 * @property string $module_name
 * @property string $var_name
 * @property string $class_name
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Property extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_name', 'class_name'], 'required'],
            [['module_name'], 'string', 'max' => 120],
            [['var_name'], 'string', 'max' => 40],
            [['class_name'], 'string', 'max' => 200],
            [['var_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_name' => 'Module Name',
            'var_name' => 'Var Name',
            'class_name' => 'Class Name',
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
