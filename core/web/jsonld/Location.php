<?php

namespace luya\web\jsonld;

class Location extends BaseThing
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
    
    public function setAddress(Address $address)
    {
        $this->_addresses[] = $address;
        
        return $this;
    }
    
    public function getAddresses()
    {
        return $this->_addresses;
    }
}
