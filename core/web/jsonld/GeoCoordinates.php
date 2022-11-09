<?php

namespace luya\web\jsonld;

/**
 * Geo Coordinates
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class GeoCoordinates extends BaseThing
{
    public function typeDefintion()
    {
        return 'GeoCoordinates';
    }

    private $_address;

    /**
     * Set Address
     *
     * @param PostalAddress $address
     * @return static
     */
    public function setAddress(PostalAddress $address)
    {
        $this->_address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    private $_addressCountry;

    /**
     * Set address country
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
     * Get address country
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->_addressCountry;
    }

    private $_elevation;

    /**
     * Set elevation
     *
     * @param string $elevation
     * @return static
     */
    public function setElevation($elevation)
    {
        $this->_elevation = $elevation;

        return $this;
    }

    /**
     * get elevation
     *
     * @return string
     */
    public function getElevation()
    {
        return $this->_elevation;
    }

    private $_latitude;

    /**
     * Set Latitude
     *
     * @param string $latitude
     * @return static
     */
    public function setLatitude($latitude)
    {
        $this->_latitude = $latitude;

        return $this;
    }

    /**
     * Get Latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->_latitude;
    }

    private $_longitude;

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return static
     */
    public function setLongitude($longitude)
    {
        $this->_longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->_longitude;
    }

    private $_postalCode;

    /**
     * Set postal code
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
     * Get postal code
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->_postalCode;
    }
}
