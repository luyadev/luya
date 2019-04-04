<?php

namespace luya\web\jsonld;

/**
 * Language value
 *
 *
 * @see https://tools.ietf.org/html/bcp47
 * @see https://schema.org/availableLanguage
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class LanguageValue extends BaseValue
{
    private $_language;

    public function __construct($langauge)
    {
        $this->_language = $langauge;
    }

    public function getValue()
    {
        // RFC VALIDATION
        return $this->_language;
    }
}
