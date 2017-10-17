<?php

namespace luya\web\jsonld;

class Location extends BaseGraphElement
{
	private $_name;
	
	public function setName($name)
	{
		$this->_name = $name;
		return $this;
	}

	public function getName()
	{
		return $this->_name;
	}
	
	private $_addresses;
	
	public function setAddress(array $config = [])
	{
		$object = new Address();
		
		$this->_addresses[] = $object;
		
		return $object;
	}
	
	public function getAddresses()
	{
		return $this->_addresses;
	}
	
	public function fields()
	{
		return [
			'name', 
			'addresses',
		];
	}
}