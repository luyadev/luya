<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/ImageObject
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait ImageObjectTrait
{
    use MediaObjectTrait;
	
	private $_caption;
	
	public function setCaption($caption)
	{
	    $this->_caption = $caption;
	    return $this;
	}
	
	public function getCaption()
	{
	    return $this->_caption;
	}
	
	private $_exifData;
	
	public function setExifData(PropertyValue $propertyValue)
	{
	   $this->_exifData = $propertyValue;
	   
	   return $this;
	}
	
	public function getExifData()
	{
	    return $this->_exifData;
	}
	
	private $_representativeOfPage;
	
	public function setRepresentativeOfPage($representativeOfPage)
	{
	   $this->_representativeOfPage = $representativeOfPage;
	   
	   return $this;
	}
	
	public function getRepresentativeOfPage()
	{
	    return $this->_representativeOfPage;
	}
	
	private $_thumbnail;
	
	public function setThumbnail(ImageObject $imageObject)
	{
	    $this->_thumbnail = $imageObject;
	    
	    return $this;
	}
	
	public function getThumbnail()
	{
	    return $this->_thumbnail;
	}
}