<?php

namespace luya\web\jsonld;

class Address extends BaseGraphElement
{
	private $_street;
	
	public function setStreet($street)
	{
		$this->_street = $street;
		return $this;
	}
	
	public function getStreet()
	{
		return $this->_street;
	}
	
	private $_zip;
	
	public function setZip($zip)
	{
		$this->_zip = $zip;
		
		return $this;
	}
	
	public function getZip()
	{
		return $this->_zip;
	}
	
	private $_city;
	
	public function setCity($city)
	{
		$this->_city = $city;
		
		return $this;
	}
	
	public function getCity()
	{
		return $this->_city;
	}
	
	
	public function fields()
	{
		return [
			'street', 'zip', 'city',
		];
	}
}