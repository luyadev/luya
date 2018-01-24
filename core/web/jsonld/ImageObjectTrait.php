<?php

namespace luya\web\jsonld;

/**
 * JsonLd ImageObject.
 * 
 * @see http://schema.org/ImageObject
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait ImageObjectTrait
{
    use MediaObjectTrait;
	
	private $_caption;
	
	/**
	 * {@inheritdoc}
	 */
	public function setCaption($caption)
	{
	    $this->_caption = $caption;
	    return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getCaption()
	{
	    return $this->_caption;
	}
	
	private $_exifData;
	
	/**
	 * {@inheritdoc}
	 */
	public function setExifData(PropertyValue $propertyValue)
	{
	   $this->_exifData = $propertyValue;
	   
	   return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getExifData()
	{
	    return $this->_exifData;
	}
	
	private $_representativeOfPage;
	
	/**
	 * {@inheritdoc}
	 */
	public function setRepresentativeOfPage($representativeOfPage)
	{
	   $this->_representativeOfPage = $representativeOfPage;
	   
	   return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getRepresentativeOfPage()
	{
	    return $this->_representativeOfPage;
	}
	
	private $_thumbnail;
	
	/**
	 * {@inheritdoc}
	 */
	public function setThumbnail(ImageObject $imageObject)
	{
	    $this->_thumbnail = $imageObject;
	    
	    return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getThumbnail()
	{
	    return $this->_thumbnail;
	}
}