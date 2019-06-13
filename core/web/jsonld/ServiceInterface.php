<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Service interface
 *
 * A service provided by an organization, e.g. delivery service, print services, etc.
 *
 * @see http://schema.org/Service
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.19
 */
interface ServiceInterface extends  IntangibleInterface
{
    /**
     * Set aggregate rating
     *
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @param AggregateRating $rating
     * @return static
     */
    public function setAggregateRating($aggregateRating);

    /**
     * Get aggregate rating
     *
     * @return string
     */
    public function getAggregateRating();

    /**
     * Set area served
     *
     * The geographic area where a service or offered item is provided. Supersedes serviceArea.
     *
     * @param mixed $areaServed
     * @return static
     */
    public function setAreaServed($areaServed);

    /**
     * Get area served
     *
     * @return string
     */
    public function getAreaServed();

    /**
     * Set the audience.
     *
     * An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.
     *
     * @param Audience $audience
     * @return static
     */
    public function setAudience($audience);

    /**
     * Get the audience
     *
     * @return string
     */
    public function getAudience();

    /**
     * Set available channel
     *
     * A means of accessing the service (e.g. a phone bank, a web site, a location, etc.).
     *
     * @param ServiceChannel $availableChannel
     * @return static
     */
    public function setAvailableChannel($availableChannel);

    /**
     * Get available channel
     *
     * @return string
     */
    public function getAvailableChannel();

    /**
     * Set an award
     *
     * An award won by or for this item. Supersedes awards.
     *
     * @param mixed $award
     * @return static
     */
    public function setAward($award);

    /**
     * Get the award
     *
     * @return string
     */
    public function getAward();

    /**
     * Set a brand
     *
     * The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     *
     * @param mixed $brand
     * @return static
     */
    public function setBrand($brand);

    /**
     * Get the brand
     *
     * @return string
     */
    public function getBrand();

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
    public function setBroker($broker);

    /**
     * Get the broker
     *
     * @return string
     */
    public function getBroker();

    /**
     * Set the category
     *
     * A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     *
     * @param mixed $category
     * @return static
     */
    public function setCategory($category);

    /**
     * Get the category
     *
     * @return string
     */
    public function getCategory();

    /**
     * Set whether service has an offer catalog
     *
     * Indicates an OfferCatalog listing for this Organization, Person, or Service.
     *
     * @param mixed $hasOfferCatalog
     * @return static
     */
    public function setHasOfferCatalog($hasOfferCatalog);

    /**
     * Get the offer catalog indication
     *
     * @return string
     */
    public function getHasOfferCatalog();

    /**
     * Set the hours available
     *
     * The hours during which this service or contact is available.
     *
     * @param mixed $hoursAvailable
     * @return static
     */
    public function setHoursAvailable($hoursAvailable);

    /**
     * Get the hours available
     *
     * @return string
     */
    public function getHoursAvailable();

    /**
     * Set a related product
     *
     * A pointer to another, somehow related product (or multiple products).
     *
     * @param mixed $isRelatedTo
     * @return static
     */
    public function setIsRelatedTo($isRelatedTo);

    /**
     * Get related items
     *
     * @return string
     */
    public function getIsRelatedTo();

    /**
     * Set similar items
     *
     * A pointer to another, functionally similar product (or multiple products).
     *
     * @param mixed $isSimilarTo
     * @return static
     */
    public function setIsSimilarTo($isSimilarTo);

    /**
     * Get similar items
     *
     * @return string
     */
    public function getIsSimilarTo();

    /**
     * Set the logo
     *
     * An associated logo.
     *
     * @param mixed $logo
     * @return static
     */
    public function setLogo($logo);

    /**
     * Get the logo
     *
     * @return string
     */
    public function getLogo();

    /**
     * Set offers
     *
     * An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service,
     * or give away tickets to an event.
     *
     * @param mixed $offers
     * @return static
     */
    public function setOffers($offers);

    /**
     * Get offers
     *
     * @return string
     */
    public function getOffers();

    /**
     * Set the service provider
     *
     * The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller. Supersedes carrier.
     *
     * @param mixed $provider
     * @return static
     */
    public function setProvider($provider);

    /**
     * Get the provider
     *
     * @return string
     */
    public function getProvider();
    /**
     * Set the provider mobility
     *
     * Indicates the mobility of a provided service (e.g. 'static', 'dynamic').
     *
     * @param mixed $providerMobility
     * @return static
     */
    public function setProviderMobility($providerMobility);

    /**
     * Get the provider mobility
     *
     * @return string
     */
    public function getProviderMobility();

    /**
     * Set a review
     *
     * A review of the item. Supersedes reviews.
     *
     * @param mixed $review
     * @return static
     */
    public function setReview($review);

    /**
     * Get a review
     *
     * @return string
     */
    public function getReview();

    /**
     * Set the service output
     *
     * The tangible thing generated by the service, e.g. a passport, permit, etc. Supersedes produces.
     *
     * @param mixed $serviceOutput
     * @return static
     */
    public function setServiceOutput($serviceOutput);

    /**
     * Get the service output
     *
     * @return string
     */
    public function getServiceOutput();

    /**
     * Set the service type
     *
     * The type of service being offered, e.g. veterans' benefits, emergency relief, etc.
     *
     * @param mixed $serviceType
     * @return static
     */
    public function setServiceType($serviceType);

    /**
     * Get the service type
     *
     * @return string
     */
    public function getServiceType();

    /**
     * Set the slogan
     *
     * A slogan or motto associated with the item.
     *
     * @param mixed $slogan
     * @return static
     */
    public function setSlogan($slogan);

    /**
     * Get the slogan
     *
     * @return string
     */
    public function getSlogan();

    /**
     * Set the terms of service
     *
     * Human-readable terms of service documentation.
     *
     * @param mixed $termsOfService
     * @return static
     */
    public function setTermsOfService($termsOfService);

    /**
     * Get the terms of service
     *
     * @return string
     */
    public function getTermsOfService();
}