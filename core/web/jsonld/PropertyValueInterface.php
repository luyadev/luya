<?php

namespace luya\web\jsonld;

/**
 * JsonLd PropertyValue.
 *
 * @see http://schema.org/PropertyValue
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
interface PropertyValueInterface extends ThingInterface
{
    /**
     * Setter method for maxValue.
     *
     * @param string $maxValue
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setMaxValue($maxValue);
    
    /**
     * Getter method for maxValue
     */
    public function getMaxValue();
    
    /**
     * Setter method for measurement Technique.
     *
     * @param string $measurementTechnique
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setMeasurementTechnique($measurementTechnique);
    
    /**
     * Getter method for measurement Technique.
     */
    public function getMeasurementTechnique();
    
    /**
     * Setter method for minValue.
     *
     * @param string $minValue
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setMinValue($minValue);
    
    /**
     * Getter method for minValue.
     */
    public function getMinValue();
    
    /**
     * Setter method for propertyId.
     *
     * @param string $propertyID
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setPropertyID($propertyID);

    /**
     * Getter method for propertyId.
     */
    public function getPropertyID();
    
    /**
     * Setter method for unitCode.
     *
     * @param string $unitCode
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setUnitCode($unitCode);
    
    /**
     * Getter method for unitCode.
     */
    public function getUnitCode();
    
    /**
     * Setter method for unitText.
     *
     * @param string $uniText
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setUnitText($uniText);

    /**
     * Getter method for unitText.
     */
    public function getUnitText();
    
    /**
     * Setter method for value.
     *
     * @param string $value
     * @return \luya\web\jsonld\PropertyValue
     */
    public function setValue($value);

    /**
     * Getter method for value.
     */
    public function getValue();
}
