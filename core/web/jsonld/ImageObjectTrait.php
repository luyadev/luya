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
     *
     * @return static
     */
    public function setCaption($caption)
    {
        $this->_caption = $caption;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCaption()
    {
        return $this->_caption;
    }

    private $_exifData;

    /**
     *
     * @return static
     */
    public function setExifData(PropertyValue $propertyValue)
    {
        $this->_exifData = $propertyValue;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExifData()
    {
        return $this->_exifData;
    }

    private $_representativeOfPage;

    /**
     *
     * @return static
     */
    public function setRepresentativeOfPage($representativeOfPage)
    {
        $this->_representativeOfPage = $representativeOfPage;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRepresentativeOfPage()
    {
        return $this->_representativeOfPage;
    }

    private $_thumbnail;

    /**
     *
     * @return static
     */
    public function setThumbnail(ImageObject $imageObject)
    {
        $this->_thumbnail = $imageObject;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getThumbnail()
    {
        return $this->_thumbnail;
    }
}
