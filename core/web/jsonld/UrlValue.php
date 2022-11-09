<?php

namespace luya\web\jsonld;

/**
 * Value object for Urls.
 *
 * @see http://schema.org/URL
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class UrlValue extends BaseValue
{
    private $_url;

    /**
     * Provide url data.
     *
     * @param string $url
     */
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
