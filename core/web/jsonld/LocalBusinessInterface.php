<?php

namespace luya\web\jsonld;

/**
 * Local Business Interface
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
interface LocalBusinessInterface
{
    /**
     * Set accepted currencies
     *
     * @param CurrencyValue $currency
     * @return static
     */
    public function setCurrenciesAccepted(CurrencyValue $currency);

    /**
     * Get accepted currencies
     *
     * @return string
     */
    public function getCurrenciesAccepted();

    /**
     * Set Opening Hours
     *
     * @param OpeningHoursValue $openingHours
     * @return static
     */
    public function setOpeningHours(OpeningHoursValue $openingHours);

    /**
     * Get opening hours
     *
     * @return string
     */
    public function getOpeningHours();

    /**
     * Set Payment Accepted
     *
     * @param string $payment
     * @return static
     */
    public function setPaymentAccepted($payment);

    /**
     * Get payment Accepted
     *
     * @return string
     */
    public function getPaymentAccepted();

    /**
     * Set Price range
     *
     * @param string $priceRange
     * @return static
     */
    public function setPriceRange($priceRange);

    /**
     * Get price range
     *
     * @return string
     */
    public function getPriceRange();
}
