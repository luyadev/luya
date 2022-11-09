<?php

namespace luya\web\jsonld;

/**
 * JsonLd PropertyValue.
 *
 * @see http://schema.org/PropertyValue
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait PropertyValueTrait
{
    use ThingTrait;

    private $_maxValue;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setMaxValue($maxValue)
    {
        $this->_maxValue = $maxValue;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMaxValue()
    {
        return $this->_maxValue;
    }

    private $_minValue;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setMinValue($minValue)
    {
        $this->_minValue = $minValue;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMinValue()
    {
        return $this->_minValue;
    }

    private $_measurementTechnique;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setMeasurementTechnique($measurementTechnique)
    {
        $this->_measurementTechnique = $measurementTechnique;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMeasurementTechnique()
    {
        return $this->_measurementTechnique;
    }

    private $_propertyId;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setPropertyID($propertyID)
    {
        $this->_propertyId = $propertyID;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPropertyID()
    {
        return $this->_propertyId;
    }

    private $_unitCode;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setUnitCode($unitCode)
    {
        $this->_unitCode = $unitCode;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUnitCode()
    {
        return $this->_unitCode;
    }

    private $_unitText;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setUnitText($uniText)
    {
        $this->_unitText = $uniText;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUnitText()
    {
        return $this->_unitText;
    }

    private $_value;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->_value;
    }
}
