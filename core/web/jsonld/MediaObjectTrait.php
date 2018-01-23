<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/MediaObject
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait MediaObjectTrait
{
    use CreativeWorkTrait;
    
    private $_contentUrl;
    
    /**
     * Actual bytes of the media object, for example the image file or video file.
     *
     * @param UrlValue $url
     */
    public function setContentUrl(UrlValue $url)
    {   
        $this->_contentUrl = $url->getValue();
        return $this;
    }
    
    public function getContentUrl()
    {
        return $this->_contentUrl;
    }
    
    private $_embedUrl;
    
    /**
     * A URL pointing to a player for a specific video. In general, this is the information in the src element of an embed tag and should not be the same as the content of the loc tag.
     *
     * @param UrlValue $url
     */
    public function setEmbedUrl(UrlValue $url)
    {
        $this->_embedUrl = $url->getValue();
    }
    
    public function getEmbedUrl()
    {
        return $this->_embedUrl;
    }
    
    private $_uploadDate;
    
    /**
     * Date when this media object was uploaded to this site.
     * @param DateValue $date
     */
    public function setUploadDate(DateValue $date)
    {
        $this->_uploadDate = $date->getValue();
        return $this;
    }
    
    public function getUploadDate()
    {
        return $this->_uploadDate;
    }
}