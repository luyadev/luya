<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/PropertyValue
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait PropertyValueTrait
{
    use ThingTrait;
    
    private $_maxValue;
    
    public function setMaxValue($maxValue)
    {
        $this->_maxValue = $maxValue;
        
        return $this;
    }
    
    public function getMaxValue()
    {
        return $this->_maxValue;
    }
    
    private $_minValue;
    
    public function setMinValue($minValue)
    {
        $this->_minValue = $minValue;
       
        return $this;
    }
    
    public function getMinValue()
    {
        return $this->_minValue;
    }
    
    private $_measurementTechnique;
    
    public function setMeasurementTechnique($measurementTechnique)
    {
        $this->_measurementTechnique = $measurementTechnique;
        
        return $this;
    }
    
    public function getMeasurementTechnique()
    {
        return $this->_measurementTechnique;
    }
    
    private $_propertyId;
    
    public function setPropertyID($propertyID)
    {
        $this->_propertyId = $propertyID;
        
        return $this;
    }
    
    public function getPropertyID()
    {
        return $this->_propertyId;
    }
    
    private $_unitCode;
    
    public function setUnitCode($unitCode)
    {
        $this->_unitCode = $unitCode;
        
        return $this;
    }
    
    public function getUnitCode()
    {
        return $this->_unitCode;
    }
    
    private $_unitText;
    
    public function setUnitText($uniText)
    {
        $this->_unitText = $uniText;
        
        return $this;
    }
    
    public function getUnitText()
    {
        return $this->_unitText;
    }
    
    private $_value;
    
    public function setValue($value)
    {
        $this->_value = $value;
        
        return $this;
    }
    
    public function getValue()
    {
        return $this->_value;
    }
}
