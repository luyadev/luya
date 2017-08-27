<?php

namespace luya\base;

use yii\base\Object;

class PackageInstaller extends Object
{
	private $_timestamp;
	
	public function setTimestamp($timestamp)
	{
		$this->_timestamp = $timestamp;
	}
		
	public function getTimestamp()
	{
		return $this->_timestamp;
	}
	
	private $_configs = [];
	
	public function setConfigs(array $configs)
	{
		$objects = [];
		foreach ($configs as $key => $config) {
			$objects[$key] = new PackageConfig($config);
		}
		
		$this->_configs = $objects;
	}
	
	/**
	 * 
	 * @return \luya\base\PackageConfig
	 */
	public function getConfigs()
	{
		return $this->_configs;
	}
}