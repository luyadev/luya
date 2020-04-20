<?php

namespace luya\web\jsonld;

/**
 * JsonLd Offer.
 *
 * @see http://schema.org/Offer
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
trait OfferTrait
{
    use ThingTrait;

    private $_availability;

    private $_price;

    /**
     * Price Setter
     *
     * @param PriceValue $price
     * @return static
     * @since 1.2.2
     */
    public function setPrice(PriceValue $price)
    {
        $this->_price = $price->getValue();
        return $this;
    }

    /**
     * Get Price
     *
     * @return mixed
     * @since 1.2.2
     */
    public function getPrice()
    {
        return $this->_price;
    }

    private $_priceCurrency;

    /**
     * Price Currency Setter.
     *
     * @param CurrencyValue $currencyValue
     * @return static
     * @since 1.2.2
     */
    public function setPriceCurrency(CurrencyValue $currencyValue)
    {
        $this->_priceCurrency = $currencyValue->getValue();
        return $this;
    }

    /**
     * Get Price Currency
     *
     * @return string
     * @since 1.2.2
     */
    public function getPriceCurrency()
    {
        return $this->_priceCurrency;
    }
}
