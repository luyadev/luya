<?php

namespace luya\web\jsonld;

/**
 * JsonLd Offer.
 *
 * @see http://schema.org/Offer
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
interface OfferInterface extends ThingInterface
{
    /**
     * Price Setter
     *
     * @param PriceValue $price
     * @return static
     * @since 1.2.2
     */
    public function setPrice(PriceValue $price);

    /**
     * Price Getter
     *
     * @return mixed
     * @since 1.2.2
     */
    public function getPrice();

    /**
     * Price Currency Setter.
     *
     * @param CurrencyValue $currencyValue
     * @return static
     * @since 1.2.2
     */
    public function setPriceCurrency(CurrencyValue $currencyValue);

    /**
     * Price Currency Getter
     *
     * @return string
     * @since 1.2.2
     */
    public function getPriceCurrency();
}
