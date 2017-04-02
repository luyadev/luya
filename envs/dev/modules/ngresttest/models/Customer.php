<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Customer.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev.
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $address
 */
class Customer extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_customer';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'phone', 'address'], 'string', 'max' => 255],
            [['active'], 'integer']
        ];
    }

    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['name', 'phone', 'address'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-customer';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'phone' => 'text',
            'address' => 'text',
            'active' => 'toggleStatus',
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
        $this->ngRestConfigDefine($config, 'list', ['name', 'phone', 'address', 'active']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['name', 'phone', 'address', 'active']);
        
        // enable or disable ability to delete;
        $config->delete = false;
        
        return $config;
    }
}
