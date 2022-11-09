<?php

namespace luya\web\jsonld;

/**
 * JsonLd MediaObject Trait.
 *
 * @see http://schema.org/MediaObject
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait MediaObjectTrait
{
    use CreativeWorkTrait;

    private $_contentUrl;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setContentUrl(UrlValue $url)
    {
        $this->_contentUrl = $url->getValue();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContentUrl()
    {
        return $this->_contentUrl;
    }

    private $_embedUrl;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setEmbedUrl(UrlValue $url)
    {
        $this->_embedUrl = $url->getValue();
    }

    /**
     * @inheritdoc
     */
    public function getEmbedUrl()
    {
        return $this->_embedUrl;
    }

    private $_uploadDate;

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function setUploadDate(DateValue $date)
    {
        $this->_uploadDate = $date->getValue();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUploadDate()
    {
        return $this->_uploadDate;
    }
}
