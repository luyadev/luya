<?php

namespace luya\admin\models;

use yii\db\ActiveRecord;
use luya\traits\RegistryTrait;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\Module;

/**
 * This is the model class for table "admin_config".
 *
 * @property string $name
 * @property string $value
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Config extends NgRestModel
{
    use RegistryTrait;
    
    const CONFIG_LAST_IMPORT_TIMESTAMP = 'last_import_timestamp';
    
    const CONFIG_SETUP_COMMAND_TIMESTAMP = 'setup_command_timestamp';
    
    const CONFIG_INSTALLER_VENDOR_TIMESTAMP = 'installer_vendor_timestamp';
    
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
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-config';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'unique'],
            [['is_system'], 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('model_config_atr_name'),
            'value' => Module::t('model_config_atr_value'),
            'is_system' => Module::t('model_config_atr_is_system'),
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => Module::t('model_config_atr_name_hint'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'value' => 'text',
            'name' => 'slug',
            'is_system' => ['hidden', 'value' => 0],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            [['list'], ['name', 'value']],
            [['create', 'update'], ['name', 'value', 'is_system']],
            [['delete'], true],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function ngRestFind()
    {
        return parent::ngRestFind()->where(['is_system' => false]);
    }
}
