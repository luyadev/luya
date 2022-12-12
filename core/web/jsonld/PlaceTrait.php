<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Place trait
 *
 * @see https://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait PlaceTrait
{
    private $_additionalProperty;

    /**
     * @return PropertyValue
     */
    public function getAdditionalProperty()
    {
        return $this->_additionalProperty;
    }

    /**
     * A property-value pair representing an additional characteristics of the entitity,
     * e.g. a product feature or another characteristic for which there is no matching property in schema.org.
     * Note: Publishers should be aware that applications designed to use specific schema.org properties
     * (e.g. https://schema.org/width, https://schema.org/color, https://schema.org/gtin13, ...) will typically expect
     * such data to be provided using those properties, rather than using the generic
     *
     * @param PropertyValue $additionalProperty
     * @return static
     */
    public function setAdditionalProperty(PropertyValue $additionalProperty)
    {
        $this->_additionalProperty = $additionalProperty;
        return $this;
    }

    private $_address;

    /**
     * @return PostalAddress|string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Physical address of the item.
     *
     * @param PostalAddress|string $address
     * @return static
     */
    public function setAddress(PostalAddress $address)
    {
        $this->_address = $address;
        return $this;
    }

    private $_aggregateRating;

    /**
     * @return AggregateRating
     */
    public function getAggregateRating()
    {
        return $this->_aggregateRating;
    }

    /**
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @param AggregateRating $aggregateRating
     * @return static
     */
    public function setAggregateRating(AggregateRating $aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;
        return $this;
    }

    private $_amenityFeature;

    /**
     * @return LocationFeatureSpecification
     */
    public function getAmenityFeature()
    {
        return $this->_amenityFeature;
    }

    /**
     * An amenity feature (e.g. a characteristic or service) of the Accommodation.
     * This generic property does not make a statement about whether the feature is included in an offer
     * for the main accommodation or available at extra costs.
     *
     * @param LocationFeatureSpecification $amenityFeature
     * @return static
     */
    public function setAmenityFeature($amenityFeature)
    {
        $this->_amenityFeature = $amenityFeature;
        return $this;
    }

    private $_branchCode;

    /**
     * @return string
     */
    public function getBranchCode()
    {
        return $this->_branchCode;
    }

    /**
     * A short textual code (also called "store code") that uniquely identifies a place of business.
     * The code is typically assigned by the parentOrganization and used in structured URLs.
     * For example, in the URL https://www.starbucks.co.uk/store-locator/etc/detail/3047
     * the code "3047" is a branchCode for a particular branch.
     *
     * @param string $branchCode
     * @return static
     */
    public function setBranchCode($branchCode)
    {
        $this->_branchCode = $branchCode;
        return $this;
    }

    private $_containedInPlace;

    /**
     * @return Place
     */
    public function getContainedInPlace()
    {
        return $this->_containedInPlace;
    }

    /**
     * The basic containment relation between a place and one that contains it.
     * Supersedes containedIn.
     * Inverse property: containsPlace.
     *
     * @param Place $containedInPlace
     * @return static
     */
    public function setContainedInPlace(Place $containedInPlace)
    {
        $this->_containedInPlace = $containedInPlace;
        return $this;
    }

    private $_containsPlace;

    /**
     * @return Place
     */
    public function getContainsPlace()
    {
        return $this->_containsPlace;
    }

    /**
     * The basic containment relation between a place and another that it contains.
     * Inverse property: containedInPlace.
     *
     * @param Place $containsPlace
     * @return static
     */
    public function setContainsPlace(Place $containsPlace)
    {
        $this->_containsPlace = $containsPlace;
        return $this;
    }

    private $_event;

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->_event;
    }

    /**
     * Upcoming or past event associated with this place, organization, or action.
     * Supersedes events.
     *
     * @param Event $event
     * @return static
     */
    public function setEvent(Event $event)
    {
        $this->_event[] = $event;
        return $this;
    }

    private $_faxNumber;

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }

    /**
     * The fax number.
     *
     * @param string $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber = $faxNumber;
        return $this;
    }

    private $_geo;

    /**
     * @return GeoCoordinates
     */
    public function getGeo()
    {
        return $this->_geo;
    }

    /**
     * The geo coordinates of the place.
     *
     * @param GeoCoordinates $geo
     * @return static
     */
    public function setGeo(GeoCoordinates $geo)
    {
        $this->_geo = $geo;
        return $this;
    }

    private $_geospatiallyContains;

    /**
     * @return mixed
     */
    public function getGeospatiallyContains()
    {
        return $this->_geospatiallyContains;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a containing geometry
     * to a contained geometry. "a contains b iff no points of b lie in the exterior of a, and at least one point
     * of the interior of b lies in the interior of a". As defined in DE-9IM.
     *
     * @param mixed $geospatiallyContains
     * @return static
     */
    public function setGeospatiallyContains($geospatiallyContains)
    {
        $this->_geospatiallyContains = $geospatiallyContains;
        return $this;
    }

    private $_geospatiallyCoveredBy;

    /**
     * @return mixed
     */
    public function getGeospatiallyCoveredBy()
    {
        return $this->_geospatiallyCoveredBy;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent),
     * relating a geometry to another that covers it. As defined in DE-9IM.
     *
     * @param mixed $geospatiallyCoveredBy
     * @return static
     */
    public function setGeospatiallyCoveredBy($geospatiallyCoveredBy)
    {
        $this->_geospatiallyCoveredBy = $geospatiallyCoveredBy;
        return $this;
    }

    private $_geospatiallyCovers;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCovers()
    {
        return $this->_geospatiallyCovers;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a covering geometry
     * to a covered geometry. "Every point of b is a point of (the interior or boundary of) a". As defined in DE-9IM.
     *
     * @param GeospatialGeometry|Place $geospatiallyCovers
     * @return static
     */
    public function setGeospatiallyCovers($geospatiallyCovers)
    {
        $this->_geospatiallyCovers = $geospatiallyCovers;
        return $this;
    }

    private $_geospatiallyCrosses;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCrosses()
    {
        return $this->_geospatiallyCrosses;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry to another
     * that crosses it: "a crosses b: they have some but not all interior points in common, and the dimension of the
     * intersection is less than that of at least one of them". As defined in DE-9IM.
     *
     * @param GeospatialGeometry|Place $geospatiallyCrosses
     * @return static
     */
    public function setGeospatiallyCrosses($geospatiallyCrosses)
    {
        $this->_geospatiallyCrosses = $geospatiallyCrosses;
        return $this;
    }

    private $_geospatiallyDisjoint;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyDisjoint()
    {
        return $this->_geospatiallyDisjoint;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) are topologically disjoint:
     * they have no point in common. They form a set of disconnected geometries."
     * (a symmetric relationship, as defined in DE-9IM)
     *
     * @param GeospatialGeometry|Place $geospatiallyDisjoint
     * @return static
     */
    public function setGeospatiallyDisjoint($geospatiallyDisjoint)
    {
        $this->_geospatiallyDisjoint = $geospatiallyDisjoint;
        return $this;
    }

    private $_geospatiallyEquals;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyEquals()
    {
        return $this->_geospatiallyEquals;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) are topologically equal,
     * as defined in DE-9IM. "Two geometries are topologically equal if their interiors intersect and no part
     * of the interior or boundary of one geometry intersects the exterior of the other" (a symmetric relationship)
     *
     * @param GeospatialGeometry|Place $geospatiallyEquals
     * @return static
     */
    public function setGeospatiallyEquals($geospatiallyEquals)
    {
        $this->_geospatiallyEquals = $geospatiallyEquals;
        return $this;
    }

    private $_geospatiallyIntersects;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyIntersects()
    {
        return $this->_geospatiallyIntersects;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) have at least one point
     * in common. As defined in DE-9IM.
     *
     * @param mixed $geospatiallyIntersects
     * @return static
     */
    public function setGeospatiallyIntersects($geospatiallyIntersects)
    {
        $this->_geospatiallyIntersects = $geospatiallyIntersects;
        return $this;
    }

    private $_geospatiallyOverlaps;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyOverlaps()
    {
        return $this->_geospatiallyOverlaps;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry
     * to another that geospatially overlaps it, i.e. they have some but not all points in common. As defined in DE-9IM.
     *
     * @param GeospatialGeometry|Place $geospatiallyOverlaps
     * @return static
     */
    public function setGeospatiallyOverlaps($geospatiallyOverlaps)
    {
        $this->_geospatiallyOverlaps = $geospatiallyOverlaps;
        return $this;
    }

    private $_geospatiallyTouches;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyTouches()
    {
        return $this->_geospatiallyTouches;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) touch: they have
     * at least one boundary point in common, but no interior points." (a symmetric relationship, as defined in DE-9IM )
     *
     * @param GeospatialGeometry|Place $geospatiallyTouches
     * @return static
     */
    public function setGeospatiallyTouches($geospatiallyTouches)
    {
        $this->_geospatiallyTouches = $geospatiallyTouches;
        return $this;
    }

    private $_geospatiallyWithin;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyWithin()
    {
        return $this->_geospatiallyWithin;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry to one
     * that contains it, i.e. it is inside (i.e. within) its interior. As defined in DE-9IM.
     *
     * @param GeospatialGeometry|Place $geospatiallyWithin
     * @return static
     */
    public function setGeospatiallyWithin($geospatiallyWithin)
    {
        $this->_geospatiallyWithin = $geospatiallyWithin;
        return $this;
    }

    private $_globalLocationNumber;

    /**
     * @return string
     */
    public function getGlobalLocationNumber()
    {
        return $this->_globalLocationNumber;
    }

    /**
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties
     * and physical locations.
     *
     * @param string $globalLocationNumber
     * @return static
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->_globalLocationNumber = $globalLocationNumber;
        return $this;
    }

    private $_hasMap;

    /**
     * @return Map
     */
    public function getHasMap()
    {
        return $this->_hasMap;
    }

    /**
     * A URL to a map of the place.
     * Supersedes map, maps.
     *
     * @param Map $hasMap
     * @return static
     */
    public function setHasMap($hasMap)
    {
        $this->_hasMap = $hasMap;
        return $this;
    }

    private $_isAccessibleForFree;

    /**
     * @return bool
     */
    public function isAccessibleForFree()
    {
        return $this->_isAccessibleForFree;
    }

    /**
     * A flag to signal that the item, event, or place is accessible for free.
     * Supersedes free.
     *
     * @param bool $isAccessibleForFree
     * @return static
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    private $_isicV4;

    /**
     * @return string
     */
    public function getIsicV4()
    {
        return $this->_isicV4;
    }

    /**
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @param string $isicV4
     * @return static
     */
    public function setIsicV4($isicV4)
    {
        $this->_isicV4 = $isicV4;
        return $this;
    }

    private $_logo;

    /**
     * @return ImageObject
     */
    public function getLogo()
    {
        return $this->_logo;
    }

    /**
     * An associated logo.
     *
     * @param ImageObject $logo
     * @return static
     */
    public function setLogo(ImageObject $logo)
    {
        $this->_logo = $logo;
        return $this;
    }

    private $_maximumAttendeeCapacity;

    /**
     * @return int
     */
    public function getMaximumAttendeeCapacity()
    {
        return $this->_maximumAttendeeCapacity;
    }

    /**
     * The total number of individuals that may attend an event or venue.
     *
     * @param int $maximumAttendeeCapacity
     * @return static
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity)
    {
        $this->_maximumAttendeeCapacity = $maximumAttendeeCapacity;
        return $this;
    }

    private $_openingHoursSpecification;

    /**
     * @return OpeningHoursSpecification
     */
    public function getOpeningHoursSpecification()
    {
        return $this->_openingHoursSpecification;
    }

    /**
     * The opening hours of a certain place.
     *
     * @param OpeningHoursSpecification $openingHoursSpecification
     * @return static
     */
    public function setOpeningHoursSpecification($openingHoursSpecification)
    {
        $this->_openingHoursSpecification = $openingHoursSpecification;
        return $this;
    }

    private $_photo;

    /**
     * @return ImageObject|Photograph
     */
    public function getPhoto()
    {
        return $this->_photo;
    }

    /**
     * A photograph of this place. Supersedes photos.
     *
     * @param ImageObject|Photograph $photo
     * @return static
     */
    public function setPhoto($photo)
    {
        $this->_photo = $photo;
        return $this;
    }

    private $_publicAccess;

    /**
     * @return bool
     */
    public function isPublicAccess()
    {
        return $this->_publicAccess;
    }

    /**
     * A flag to signal that the Place is open to public visitors.
     * If this property is omitted there is no assumed default boolean value
     *
     * @param bool $publicAccess
     * @return static
     */
    public function setPublicAccess($publicAccess)
    {
        $this->_publicAccess = $publicAccess;
        return $this;
    }

    private $_review;

    /**
     * @return Review
     */
    public function getReview()
    {
        return $this->_review;
    }

    /**
     * A review of the item. Supersedes reviews.
     *
     * @param Review $review
     * @return static
     */
    public function setReview(Review $review)
    {
        $this->_review[] = $review;
        return $this;
    }

    private $_smokingAllowed;

    /**
     * @return bool
     */
    public function isSmokingAllowed()
    {
        return $this->_smokingAllowed;
    }

    /**
     * Indicates whether it is allowed to smoke in the place, e.g. in the restaurant, hotel or hotel room.
     *
     * @param bool $smokingAllowed
     * @return static
     */
    public function setSmokingAllowed($smokingAllowed)
    {
        $this->_smokingAllowed = $smokingAllowed;
        return $this;
    }

    private $_specialOpeningHoursSpecification;

    /**
     * @return OpeningHoursSpecification
     */
    public function getSpecialOpeningHoursSpecification()
    {
        return $this->_specialOpeningHoursSpecification;
    }

    /**
     * The special opening hours of a certain place.
     * Use this to explicitly override general opening hours brought in scope by
     * openingHoursSpecification or openingHours.
     *
     * @param OpeningHoursSpecification $specialOpeningHoursSpecification
     * @return static
     */
    public function setSpecialOpeningHoursSpecification($specialOpeningHoursSpecification)
    {
        $this->_specialOpeningHoursSpecification = $specialOpeningHoursSpecification;
        return $this;
    }

    private $_telephone;

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * The telephone number.
     *
     * @param string $telephone
     * @return static
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        return $this;
    }
}
