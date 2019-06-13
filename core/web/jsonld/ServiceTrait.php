<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Service trait
 *
 * A service provided by an organization, e.g. delivery service, print services, etc.
 *
 * @see http://schema.org/Service
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.19
 */
trait ServiceTrait
{
    private $_aggregateRating;

    /**
     * Set aggregate rating
     *
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @param AggregateRating $rating
     * @return static
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;

        return $this;
    }

    /**
     * Get aggregate rating
     *
     * @return string
     */
    public function getAggregateRating()
    {
        return $this->_aggregateRating;
    }

    private $_areaServed;

    /**
     * Set area served
     *
     * The geographic area where a service or offered item is provided. Supersedes serviceArea.
     *
     * @param mixed $areaServed
     * @return static
     */
    public function setAreaServed($areaServed)
    {
        $this->_areaServed = $areaServed;

        return $this;
    }

    /**
     * Get area served
     *
     * @return string
     */
    public function getAreaServed()
    {
        return $this->_areaServed;
    }

    private $_audience;

    /**
     * Set the audience.
     *
     * An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.
     *
     * @param Audience $audience
     * @return static
     */
    public function setAudience($audience)
    {
        $this->_audience = $audience;
        return $this;
    }

    /**
     * Get the audience
     *
     * @return string
     */
    public function getAudience()
    {
        return $this->_audience;
    }

    private $_availableChannel;

    /**
     * Set available channel
     *
     * A means of accessing the service (e.g. a phone bank, a web site, a location, etc.).
     *
     * @param ServiceChannel $availableChannel
     * @return static
     */
    public function setAvailableChannel($availableChannel)
    {
        $this->_availableChannel = $availableChannel;
        return $this;
    }

    /**
     * Get available channel
     *
     * @return string
     */
    public function getAvailableChannel()
    {
        return $this->_availableChannel;
    }

    private $_award;

    /**
     * Set an award
     *
     * An award won by or for this item. Supersedes awards.
     *
     * @param mixed $award
     * @return static
     */
    public function setAward($award)
    {
        $this->_award = $award;

        return $this;
    }

    /**
     * Get the award
     *
     * @return string
     */
    public function getAward()
    {
        return $this->_award;
    }

    private $_brand;

    /**
     * Set a brand
     *
     * The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     *
     * @param mixed $brand
     * @return static
     */
    public function setBrand($brand)
    {
        $this->_brand = $brand;
        return $this;
    }

    /**
     * Get the brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->_brand;
    }

    private $_broker;

    /**
     * Set the broker
     *
     * An entity that arranges for an exchange between a buyer and a seller. In most cases a broker never acquires or
     * releases ownership of a product or service involved in an exchange. If it is not clear whether an entity is a
     * broker, seller, or buyer, the latter two terms are preferred. Supersedes bookingAgent.
     *
     * @param mixed $broker
     * @return static
     */
    public function setBroker($broker)
    {
        $this->_broker = $broker;

        return $this;
    }

    /**
     * Get the broker
     *
     * @return string
     */
    public function getBroker()
    {
        return $this->_broker;
    }

    private $_category;

    /**
     * Set the category
     *
     * A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     *
     * @param mixed $category
     * @return static
     */
    public function setCategory($category)
    {
        $this->_category = $category;

        return $this;
    }

    /**
     * Get the category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->_category;
    }

    private $_hasOfferCatalog;

    /**
     * Set whether service has an offer catalog
     *
     * Indicates an OfferCatalog listing for this Organization, Person, or Service.
     *
     * @param mixed $hasOfferCatalog
     * @return static
     */
    public function setHasOfferCatalog($hasOfferCatalog)
    {
        $this->_hasOfferCatalog = $hasOfferCatalog;

        return $this;
    }

    /**
     * Get the offer catalog indication
     *
     * @return string
     */
    public function getHasOfferCatalog()
    {
        return $this->_hasOfferCatalog;
    }

    private $_hoursAvailable;

    /**
     * Set the hours available
     *
     * The hours during which this service or contact is available.
     *
     * @param mixed $hoursAvailable
     * @return static
     */
    public function setHoursAvailable($hoursAvailable)
    {
        $this->_hoursAvailable = $hoursAvailable;

        return $this;
    }

    /**
     * Get the hours available
     *
     * @return string
     */
    public function getHoursAvailable()
    {
        return $this->_hoursAvailable;
    }

    private $_isRelatedTo;

    /**
     * Set a related product
     *
     * A pointer to another, somehow related product (or multiple products).
     *
     * @param mixed $isRelatedTo
     * @return static
     */
    public function setIsRelatedTo($isRelatedTo)
    {
        $this->_isRelatedTo = $isRelatedTo;
        return $this;
    }

    /**
     * Get related items
     *
     * @return string
     */
    public function getIsRelatedTo()
    {
        return $this->_isRelatedTo;
    }

    private $_isSimilarTo;

    /**
     * Set similar items
     *
     * A pointer to another, functionally similar product (or multiple products).
     *
     * @param mixed $isSimilarTo
     * @return static
     */
    public function setIsSimilarTo($isSimilarTo)
    {
        $this->_isSimilarTo = $isSimilarTo;

        return $this;
    }

    /**
     * Get similar items
     *
     * @return string
     */
    public function getIsSimilarTo()
    {
        return $this->_isSimilarTo;
    }

    private $_logo;

    /**
     * Set the logo
     *
     * An associated logo.
     *
     * @param mixed $logo
     * @return static
     */
    public function setLogo($logo)
    {
        $this->_logo = $logo;

        return $this;
    }

    /**
     * Get the logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->_logo;
    }

    private $_offers;

    /**
     * Set offers
     *
     * An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service,
     * or give away tickets to an event.
     *
     * @param mixed $offers
     * @return static
     */
    public function setOffers($offers)
    {
        $this->_offers = $offers;

        return $this;
    }

    /**
     * Get offers
     *
     * @return string
     */
    public function getOffers()
    {
        return $this->_offers;
    }

    private $_provider;

    /**
     * Set the service provider
     *
     * The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller. Supersedes carrier.
     *
     * @param mixed $provider
     * @return static
     */
    public function setProvider($provider)
    {
        $this->_provider = $provider;

        return $this;
    }

    /**
     * Get the provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->_provider;
    }

    private $_providerMobility;

    /**
     * Set the provider mobility
     *
     * Indicates the mobility of a provided service (e.g. 'static', 'dynamic').
     *
     * @param mixed $providerMobility
     * @return static
     */
    public function setProviderMobility($providerMobility)
    {
        $this->_providerMobility = $providerMobility;

        return $this;
    }

    /**
     * Get the provider mobility
     *
     * @return string
     */
    public function getProviderMobility()
    {
        return $this->_providerMobility;
    }

    private $_review;

    /**
     * Set a review
     *
     * A review of the item. Supersedes reviews.
     *
     * @param mixed $review
     * @return static
     */
    public function setReview($review)
    {
        $this->_review = $review;

        return $this;
    }

    /**
     * Get a review
     *
     * @return string
     */
    public function getReview()
    {
        return $this->_review;
    }

    private $_serviceOutput;

    /**
     * Set the service output
     *
     * The tangible thing generated by the service, e.g. a passport, permit, etc. Supersedes produces.
     *
     * @param mixed $serviceOutput
     * @return static
     */
    public function setServiceOutput($serviceOutput)
    {
        $this->_serviceOutput = $serviceOutput;

        return $this;
    }

    /**
     * Get the service output
     *
     * @return string
     */
    public function getServiceOutput()
    {
        return $this->_serviceOutput;
    }

    private $_serviceType;

    /**
     * Set the service type
     *
     * The type of service being offered, e.g. veterans' benefits, emergency relief, etc.
     *
     * @param mixed $serviceType
     * @return static
     */
    public function setServiceType($serviceType)
    {
        $this->_serviceType = $serviceType;

        return $this;
    }

    /**
     * Get the service type
     *
     * @return string
     */
    public function getServiceType()
    {
        return $this->_serviceType;
    }

    private $_slogan;

    /**
     * Set the slogan
     *
     * A slogan or motto associated with the item.
     *
     * @param mixed $slogan
     * @return static
     */
    public function setSlogan($slogan)
    {
        $this->_slogan = $slogan;

        return $this;
    }

    /**
     * Get the slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->_slogan;
    }

    private $_termsOfService;

    /**
     * Set the terms of service
     *
     * Human-readable terms of service documentation.
     *
     * @param mixed $termsOfService
     * @return static
     */
    public function setTermsOfService($termsOfService)
    {
        $this->_termsOfService = $termsOfService;

        return $this;
    }

    /**
     * Get the terms of service
     *
     * @return string
     */
    public function getTermsOfService()
    {
        return $this->_termsOfService;
    }
}