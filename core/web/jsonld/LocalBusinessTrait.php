<?php

namespace luya\web\jsonld;

/**
 * Local Business Trait
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
trait LocalBusinessTrait
{
    private $_currenciesAccpeted;
    /**
     * Set accepted currencies
     *
     * @param CurrencyValue $currency
     * @return static
     */
    public function setCurrenciesAccepted(CurrencyValue $currency)
    {
        $this->_currenciesAccpeted = $currency->getValue();

        return $this;
    }

    /**
     * Get accepted currencies
     *
     * @return string
     */
    public function getCurrenciesAccepted()
    {
        return $this->_currenciesAccpeted;
    }

    private $_openingHours;

    /**
     * Set Opening Hours
     *
     * @param OpeningHoursValue $openingHours
     * @return static
     */
    public function setOpeningHours(OpeningHoursValue $openingHours)
    {
        $this->_openingHours = $openingHours->getValue();

        return $this;
    }

    /**
     * Get opening hours
     *
     * @return string
     */
    public function getOpeningHours()
    {
        return $this->_openingHours;
    }

    private $_paymentAccepted;

    /**
     * Set Payment Accepted
     *
     * @param string $payment
     * @return static
     */
    public function setPaymentAccepted($payment)
    {
        $this->_paymentAccepted = $payment;

        return $this;
    }

    /**
     * Get payment Accepted
     *
     * @return string
     */
    public function getPaymentAccepted()
    {
        return $this->_paymentAccepted;
    }

    private $_priceRange;

    /**
     * Set Price range
     *
     * @param string $priceRange
     * @return static
     */
    public function setPriceRange($priceRange)
    {
        $this->_priceRange = $priceRange;

        return $this;
    }

    /**
     * Get price range
     *
     * @return string
     */
    public function getPriceRange()
    {
        return $this->_priceRange;
    }
}
