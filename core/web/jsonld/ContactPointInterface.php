<?php

namespace luya\web\jsonld;

/**
 * JsonLd ContactPoint Interface.
 *
 * @see http://schema.org/ContactPoint
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
interface ContactPointInterface extends ThingInterface
{
    /**
     * Setter method for email.
     *
     * @param string $email
     * @return static
     */
    public function setEmail($email);
    
    /**
     * Getter method for email.
     *
     * @return string
     */
    public function getEmail();
    
    /**
     * Setter method for telephone.
     *
     * @param string $telephone
     * @return static
     */
    public function setTelephone($telephone);
    
    /**
     * Getter method for telephone.
     *
     * @return string
     */
    public function getTelephone();
}
