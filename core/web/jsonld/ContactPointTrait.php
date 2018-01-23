<?php

namespace luya\web\jsonld;

trait ContactPointTrait
{
    use ThingTrait;

    private $_email;
    
    public function setEmail($email)
    {
        $this->_email = $email;
        
        return $this;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    private $_telephone;
    
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        
        return $this;
    }
    
    public function getTelephone()
    {
        return $this->_telephone;
    }
}