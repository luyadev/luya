<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/URL
 *
 * @author nadar
 *
 */
class UrlValue extends BaseValue
{
    private $_url;
    
    public function __construct($url)
    {
        $this->_url = $url;
    }
    
    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->_url;
    }
}
