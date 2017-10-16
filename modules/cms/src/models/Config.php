<?php

namespace luya\cms\models;

use luya\traits\RegistryTrait;

/**
 * This is the model class for table "cms_config".
 *
 * @property integer $name
 * @property string $value
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Config extends \yii\db\ActiveRecord
{
    use RegistryTrait;
    
    const HTTP_EXCEPTION_NAV_ID = 'httpExceptionNavId';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_config';
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
