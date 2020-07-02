<?php

namespace luya\web\jsonld;

/**
 * The price accepted.
 *
 * Use '.' (Unicode 'FULL STOP' (U+002E)) rather than ',' to indicate a decimal point. Avoid using these symbols as a readability separator.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.2.2
 */
class PriceValue extends BaseValue
{
    private $_price;

    public function __construct($price)
    {
        $this->_price = $price;
    }

    public function getValue()
    {
        return str_replace(",", ".", $this->_price);
    }
}
