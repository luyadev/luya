<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\plugins\SelectModel;

/**
 * Order.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev.
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $title
 */
class Order extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_order';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['title'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-order';
    }
    
    public function getCustomerName()
    {
        return $this->customer->address;
    }
    
    public function getOriginalCustomerId()
    {
        return $this->getOldAttribute('customer_id');
    }
    
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'originalCustomerId']);
    }

    public function extraFields()
    {
        return [
            'customerName',
        ];
    }
    
    public function ngRestExtraAttributeTypes()
    {
        return [
            'customerName' => 'text',
        ];
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'customer_id' => [
                'class' => SelectModel::class,
                'modelClass' => Customer::className(),
                'valueField' => 'id',
                'labelField' => 'name',
            ],
            'title' => 'text',
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
        $this->ngRestConfigDefine($config, 'list', ['customer_id', 'title', 'customerName']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['customer_id', 'title']);
        
        // enable or disable ability to delete;
        $config->delete = false;
        
        return $config;
    }
}
