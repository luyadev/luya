<?php

namespace luya\web\jsonld;

class Person extends BaseThing
{
    private $_givenName;
    
    public function setGivenName($givenName)
    {
        $this->_givenName = $givenName;
        
        return $this;
    }
    
    public function getGivenName()
    {
        return $this->_givenName;
    }
    
    private $_familyName ;
    
    public function setFamilyName($familyName)
    {
        $this->_familiyName = $familyName;
        
        return $this;
    }
    
    public function getFamilyName()
    {
        return $this->_familyName;
    }
    
    public function fields()
    {
        return ['name', 'givenName', 'familyName'];
    }
}
