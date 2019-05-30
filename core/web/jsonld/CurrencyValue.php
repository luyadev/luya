<?php

namespace luya\web\jsonld;

/**
 * The currency accepted.
 *
 * Use standard formats: ISO 4217 currency format e.g. "USD"; Ticker symbol for cryptocurrencies e.g. "BTC"; well known names
 * for Local Exchange Tradings Systems (LETS) and other currency types e.g. "Ithaca HOUR".
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class CurrencyValue extends BaseValue
{
    private $_currency;

    public function __construct($currency)
    {
        $this->_currency = $currency;
    }

    public function getValue()
    {
        return $this->_currency;
    }
}
