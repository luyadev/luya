<?php

namespace luya\admin\models;

use yii\helpers\Json;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * This is the model class for table "admin_proxy_build".
 *
 * @property integer $id
 * @property integer $machine_id
 * @property integer $timestamp
 * @property string $build_token
 * @property string $config
 * @property integer $is_complet
 * @property integer $expiration_time
 * @property array $arrayConfig
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ProxyBuild extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_proxy_build';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['machine_id', 'timestamp', 'build_token', 'config', 'expiration_time'], 'required'],
            [['machine_id', 'timestamp', 'expiration_time'], 'integer'],
            [['is_complet'], 'boolean'],
            [['config'], 'string'],
            [['build_token'], 'string', 'max' => 255],
            [['build_token'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_id' => 'Machine ID',
            'timestamp' => 'Timestamp',
            'build_token' => 'Build Token',
            'config' => 'Config',
            'is_complet' => 'Is Complet',
            'expiration_time' => 'Expiration Time',
        ];
    }
    
    public function getProxyMachine()
    {
        return $this->hasOne(ProxyMachine::class, ['id' => 'machine_id']);
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-proxybuild';
    }
    
    private $_arrayConfig;
    
    public function getArrayConfig()
    {
        if ($this->_arrayConfig === null) {
            $this->_arrayConfig = Json::decode($this->config);
        }
        
        return $this->_arrayConfig;
    }
    
    public function getRowsPerRequest()
    {
        return $this->arrayConfig['rowsPerRequest'];
    }
    
    public function getTableConfig($table)
    {
        return isset($this->arrayConfig['tables'][$table]) ? $this->arrayConfig['tables'][$table] : false;
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'machine_id' => ['selectModel', 'modelClass' => ProxyMachine::class, 'valueField' => 'id', 'labelField' => 'name'],
            'timestamp' => 'datetime',
            'build_token' => 'text',
            'is_complet' => 'toggleStatus',
            'expiration_time' => 'datetime',
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
        $config->aw->load([
            'class' => DetailViewActiveWindow::class,
        ]);
        
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['machine_id', 'build_token', 'expiration_time', 'is_complet']);
        
        return $config;
    }
}
