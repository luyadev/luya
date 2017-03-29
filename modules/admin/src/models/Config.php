<?php

namespace luya\admin\models;

use yii\db\ActiveRecord;
use luya\traits\RegistryTrait;

/**
 * This is the model class for table "admin_config".
 *
 * @property string $name
 * @property string $value
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class Config extends ActiveRecord
{
    use RegistryTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
