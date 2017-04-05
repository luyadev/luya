<?php

namespace luya\admin\proxy;

use Yii;
use yii\base\Object;
use luya\console\Command;
use yii\base\InvalidConfigException;
use luya\helpers\StringHelper;

class ClientBuild extends Object
{
    /**
     * @var \luya\console\Command $command object
     */
    public $command = null;
    
    public $buildToken = null;
    
    public $requestUrl = null;
    
    public $requestCloseUrl = null;
    
    public $fileProviderUrl = null;
    
    public $imageProviderUrl = null;
    
    public $machineIdentifier = null;

    public $machineToken = null;
    
    public $storageFilesCount = null;
    
    public $optionStrict = null;
    
    public $optionTable = null;
    
    public function __construct(Command $command, array $config = [])
    {
        $this->command = $command;
        parent::__construct($config);
    }
    
    public function init()
    {
        parent::init();
        
        if ($this->_buildConfig === null) {
            throw new InvalidConfigException("build config can not be empty!");
        }
        
        $this->optionTable = explode(",", $this->optionTable);
    }
    
    private $_buildConfig = null;
    
    public function setBuildConfig(array $config)
    {
        $this->_buildConfig = $config;
        
        foreach ($config['tables'] as $tableName => $tableConfig) {
            if (!empty($this->optionTable)) {
                foreach ($this->optionTable as $useName) {
                    if ($useName != $tableName || !StringHelper::startsWithWildcard($tableName, $useName)) {
                        continue;
                    }
                }
            }
            
            $schema = Yii::$app->db->getTableSchema($tableName);
            
            if ($schema !== null) {
                $this->_tables[$tableName] = new ClientTable($this, $tableConfig);
            }
        }
    }
    
    public function getStorageFilesCount()
    {
        return $this->_buildConfig['storageFilesCount'];
    }
    
    private $_tables = [];
    
    public function getTables()
    {
        return $this->_tables;
    }
}
