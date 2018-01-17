<?php

use luya\web\jsonld\ThingInterface;

interface PropertyValueInterface extends ThingInterface
{
	public function setMaxValue($maxValue);
	
	public function getMaxValue();
	
	public function setMeasurementTechnique($measurementTechnique);
	
	public function getMeasurementTechnique();
	
	public function setMinValue($minValue);
	
	public function getMinValue();
	
	public function setPropertyID($propertyID);

	public function getPropertyID();
	
	public function setUnitCode($unitCode);
	
	public function getUnitCode();
	
	public function setUnitText($uniText);

	public function getUnitText();
	
	public function setValue($value);

	public function getValue();
}