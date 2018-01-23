<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/ImageObject
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
interface ImageObjectInterface extends MediaObjectInterface
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