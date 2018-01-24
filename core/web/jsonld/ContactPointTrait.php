<?php

namespace luya\web\jsonld;

/**
 * JsonLd ContactPoint Trait.
 *
 * @see http://schema.org/ContactPoint
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait ContactPointTrait
{
    use ThingTrait;

    private $_email;
    
    /**
     * Setter method for email.
     *
     * @param string $email
     * @return \luya\web\jsonld\ContactPoint
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        
        return $this;
    }
    
    /**
     * Getter method for email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
    
    private $_telephone;
    
    /**
     * Setter method for telephone.
     *
     * @param string $telephone
     * @return \luya\web\jsonld\ContactPoint
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        
        return $this;
    }
    
    /**
     * Getter method for telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }
}
