<?php

namespace luya\web\jsonld;

use luya\helpers\ObjectHelper;

/**
 * JsonLd ContactPoint.
 *
 * @see http://schema.org/ContactPoint
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class ContactPoint extends BaseThing
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'ContactPoint';
    }

    private $_email;
    
    /**
     * Setter method for email.
     *
     * @param string $email
     * @return static
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
     * @return static
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

    private $_areaServed;

    /**
     * Set Area Served.
     *
     * The geographic area where a service or offered item is provided. Supersedes serviceArea.
     *
     * @param Place|TextValue $areaServed
     * @return static
     */
    public function setAreaServed($areaServed)
    {
        ObjectHelper::isInstanceOf($areaServed, [Place::class, TextValue::class]);

        $this->_areaServed = $areaServed;
        return $this;
    }

    /**
     * Get Area Served.
     *
     * @return Place|TextValue
     */
    public function getAreaServed()
    {
        return $this->_areaServed;
    }

    private $_availableLanguage;

    /**
     * Set Available Language.
     *
     * A language someone may use with or at the item, service or place. Please use one of the language codes from the IETF BCP 47 standard. See also inLanguage
     *
     * @param string $availableLanguage
     * @return static
     */
    public function setAvailableLanguage($availableLanguage)
    {
        $this->_availableLanguage = $availableLanguage;
        return $this;
    }

    /**
     * Get Available Language.
     *
     * @return string
     */
    public function getAvailableLanguage()
    {
        return $this->_availableLanguage;
    }
    
    private $_contactType;

    /**
     * Set Contact Type.
     *
     * A person or organization can have different contact points, for different purposes. For example, a sales contact point, a PR contact point and so on. This property is used to specify the kind of contact point.
     *
     * @param string $contactType
     * @return static
     */
    public function setContactType($contactType)
    {
        $this->_contactType = $contactType;
        return $this;
    }

    /**
     * Get Contact Type
     *
     * @return string
     */
    public function getContactType()
    {
        return $this->_contactType;
    }

    private $_faxNumber;

    /**
     * Set Fax Number.
     *
     * The fax number.
     *
     * @param string $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber = $faxNumber;
        return $this;
    }

    /**
     * Get Fax Number.
     *
     * @return string.
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }
}
