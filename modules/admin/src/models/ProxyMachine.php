<?php

namespace luya\admin\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\traits\SoftDeleteTrait;

/**
 * Proxy Machine.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0.
 *
 * @property integer $id
 * @property string $name
 * @property tring $identifier
 * @property string $access_token
 * @property smallint $is_deleted
 * @property smallint $is_disabled
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ProxyMachine extends NgRestModel
{
    use SoftDeleteTrait;
    
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'gernateIds']);
    }
    
    public function gernateIds()
    {
        $this->identifier = uniqid('lcp');
        $this->access_token = Yii::$app->security->generateRandomString(32);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_proxy_machine';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'access_token' => Yii::t('app', 'Access Token'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'is_disabled' => Yii::t('app', 'Is Disabled'),
            'identifier' => Yii::t('app', 'Identifier'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'access_token', 'identifier'], 'required'],
            [['is_deleted', 'is_disabled'], 'boolean'],
            [['name', 'access_token', 'identifier'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['name'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-proxymachine';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'access_token' => 'text',
            'identifier' => 'text',
            'is_disabled' => 'toggleStatus',
        ];
    }
    
    /**
     * Define the NgRestConfig for this model with the ConfigBuilder object.
     *
     * @param \luya\admin\ngrest\ConfigBuilder $config The current active config builder object.
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config)
    {
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['name', 'identifier', 'access_token', 'is_disabled']);
        $this->ngRestConfigDefine($config, ['create'], ['name']);
        
        // enable or disable ability to delete;
        $config->delete = true;
        
        return $config;
    }
}
