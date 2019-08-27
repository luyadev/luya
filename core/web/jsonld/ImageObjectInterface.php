<?php

namespace luya\web\jsonld;

/**
 * JsonLd ImageObject.
 *
 * @see http://schema.org/ImageObject
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
interface ImageObjectInterface extends MediaObjectInterface
{
    /**
     * Setter methdo for Caption.
     *
     * @param string $caption
     * @return static
     */
    public function setCaption($caption);
    
    /**
     * Getter method for Caption.
     */
    public function getCaption();
    
    /**
     * Setter method for exif data via PropertyValue.
     *
     * @param PropertyValue $propertyValue
     * @return static
     */
    public function setExifData(PropertyValue $propertyValue);
    
    /**
     * Getter method for exit data.
     */
    public function getExifData();
    
    /**
     * Setter method for representative of page value
     *
     * @param string $representativeOfPage
     * @return static
     */
    public function setRepresentativeOfPage($representativeOfPage);
    
    /**
     * Getter method for representative of page value
     */
    public function getRepresentativeOfPage();
    
    /**
     * Setter method for Thumbnail.
     *
     * @param ImageObject $imageObject
     * @return static
     */
    public function setThumbnail(ImageObject $imageObject);
    
    /**
     * Getter method for thumbnail.
     */
    public function getThumbnail();
}
