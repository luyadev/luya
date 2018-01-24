<?php

namespace luya\web\jsonld;

use luya\helpers\StringHelper;
use luya\helpers\Html;

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
     */
    public function truncate($length)
    {
        $this->_text = StringHelper::truncate($this->_text, $length);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return Html::encode($this->_text);
    }
}
