<?php

namespace luya\admin\proxy;

use Yii;
use luya\console\Command;
use yii\base\InvalidConfigException;
use luya\helpers\StringHelper;
use yii\base\BaseObject;

/**
 * Admin Proxy Build.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ClientBuild extends BaseObject
{
    /**
     * @var \luya\console\Command $command object
     */
    public $command;
    
    public $buildToken;
    
    public $requestUrl;
    
    public $requestCloseUrl;
    
    public $fileProviderUrl;
    
    public $imageProviderUrl;
    
    public $machineIdentifier;

    public $machineToken;
    
    public $storageFilesCount;
    
    public $optionStrict;
    
    private $_optionTable;
    
    public function setOptionTable($table)
    {
        if (!empty($table)) {
            $this->_optionTable = explode(",", $table);
        }
    }
    
    public function getOptionTable()
    {
        return $this->_optionTable;
    }
    
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
    }
    
    private $_buildConfig;
    
    public function setBuildConfig(array $config)
    {
        $this->_buildConfig = $config;
        
        foreach ($config['tables'] as $tableName => $tableConfig) {
            if (!empty($this->optionTable)) {
                $skip = true;
                
                foreach ($this->optionTable as $useName) {
                    if ($useName == $tableName || StringHelper::startsWithWildcard($tableName, $useName)) {
                        $skip = false;
                    }
                }
                
                if ($skip) {
                    continue;
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
