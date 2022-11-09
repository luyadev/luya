<?php

namespace luya\web\jsonld;

use luya\helpers\Html;
use luya\helpers\StringHelper;

/**
 * Text Value.
 *
 * The text value provides option to auto shorten content.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class TextValue extends BaseValue
{
    private $_text;

    /**
     * Provide date data.
     *
     * @param string|integer $date
     */
    public function __construct($text)
    {
        $this->_text = $text;
    }

    /**
     * Truncate the string for a given lenth.
     *
     * @param integer $length
     * @return \luya\web\jsonld\TextValue
     */
    public function truncate($length)
    {
        $this->_text = StringHelper::truncate($this->_text, $length);

        return $this;
    }

    /**
     * Html encode the text data.
     *
     * @return \luya\web\jsonld\TextValue
     */
    public function encode()
    {
        $this->_text = Html::encode($this->_text);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->_text;
    }
}
