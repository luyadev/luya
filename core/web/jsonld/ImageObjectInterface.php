<?php

use luya\web\jsonld\CreativeWorkInterface;

interface ImageObjectInterface extends CreativeWorkInterface
{
	public function setCaption($caption);
	
	public function getCaption();
	
	public function setExifData(PropertyValue $propertyValue);
	
	public function getExifData();
	
	public function setRepresentativeOfPage($representativeOfPage);
	
	public function getRepresentativeOfPage();
	
	public function setThumbnail(ImageObject $imageObject);
	
	public function getThumbnail();
}