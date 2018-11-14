<?php

namespace luya\web\jsonld;

/**
 * JsonLd PostalAddress.
 *
 * @see http://schema.org/PostalAddress
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class PostalAddress extends ContactPoint
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'PostalAddress';
    }

    private $_addressCountry;

    /**
     * Set Address Country.
     * 
     * The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     *
     * @param string $addressCountry
     * @return static
     */
    public function setAddressCountry($addressCountry)
    {
        $this->_addressCountry = $addressCountry;
        return $this;
    }

    /**
     * Get Address Country
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->_addressCountry;
    }

    private $_addressLocality;

    /**
     * Set Address Locality.
     * 
     * The locality. For example, Mountain View.
     *
     * @param string $addressLocality
     * @return static
     */
    public function setAddressLocality($addressLocality)
    {
        $this->_addressLocality = $addressLocality;
        return $this;
    }

    /**
     * Get Address Locality.
     *
     * @return string
     */
    public function getAddressLocality()
    {
        return $this->_addressLocality;
    }

    private $_addressRegion;

    /**
     * Set Address Region.
     * 
     * The region. For example, CA.
     *
     * @param string $addressRegion
     * @return static
     */
    public function setAddressRegion($addressRegion)
    {
        $this->_addressRegion = $addressRegion;
        return $this;
    }

    /**
     * Get Address Region.
     *
     * @return string
     */
    public function getAddressRegion()
    {
        return $this->_addressRegion;
    }

    private $_postOfficeBoxNumber;

    /**
     * Set Post Office Box Number.
     * 
     * The post office box number for PO box addresses.
     *
     * @param string $postOfficeBoxNumber
     * @return static
     */
    public function setPostOfficeBoxNumber($postOfficeBoxNumber)
    {
        $this->_postOfficeBoxNumber = $postOfficeBoxNumber;
        return $this;
    }

    /**
     * Get Post Office Box Number.
     *
     * @return string
     */
    public function getPostOfficeBoxNumber()
    {
        return $this->_postOfficeBoxNumber;
    }

    private $_postalCode;

    /**
     * Set Postal Code.
     * 
     * The postal code. For example, 94043.
     *
     * @param string $postalCode
     * @return static
     */
    public function setPostalCode($postalCode)
    {
        $this->_postalCode = $postalCode;
        return $this;
    }

    /**
     * Get Postal Code.
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->_postalCode;
    }
    
    private $_streetAddress;

    /**
     * Set Street Address.
     *
     * The street address. For example, 1600 Amphitheatre Pkwy.
     * 
     * @param string $streetAddress
     * @return static
     */
    public function setStreetAddress($streetAddress)
    {
        $this->_streetAddress = $streetAddress;
        return $this;
    }

    /**
     * Get Street Address.
     *
     * @return void
     */
    public function getStreetAddress()
    {
        return $this->_streetAddress;
    }
}
