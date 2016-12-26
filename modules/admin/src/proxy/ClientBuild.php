<?php

namespace luya\admin\proxy;

use yii\base\Object;
use luya\console\Command;

class ClientBuild extends Object
{
	/**
	 * @var \luya\console\Command $command object
	 */
	public $command = null;
	
	public $buildToken = null;
	
	public $requestUrl = null;
	
	public $requestCloseUrl = null;
	
	public $machineIdentifier = null;

	public $machineToken = null;
	
	public function __construct(Command $command, array $config = [])
	{
		$this->command = $command;
		parent::__construct($config);
	}
	
	private $_buildConfig = null;
	
	public function setBuildConfig(array $config)
	{
		$this->_buildConfig = $config;
		
		foreach ($config['tables'] as $tableName => $tableConfig) {
			$this->_tables[$tableName] = new ClientTable($this, $tableConfig);
		}
	}
	
	private $_tables = [];
	
	public function getTables()
	{
		return $this->_tables;
	}
	
	
}