<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Place trait
 *
 * @see http://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait PlaceTrait
{
    /**
     * A property-value pair representing an additional characteristics of the entitity,
     * e.g. a product feature or another characteristic for which there is no matching property in schema.org.
     * Note: Publishers should be aware that applications designed to use specific schema.org properties
     * (e.g. http://schema.org/width, http://schema.org/color, http://schema.org/gtin13, ...) will typically expect
     * such data to be provided using those properties, rather than using the generic
     *
     * @var PropertyValue
     */
    private $_additionalProperty;

    /**
     * @return PropertyValue
     */
    public function getAdditionalProperty()
    {
        return $this->_additionalProperty;
    }

    /**
     * @param PropertyValue $additionalProperty
     * @return PlaceTrait
     */
    public function setAdditionalProperty($additionalProperty)
    {
        $this->_additionalProperty = $additionalProperty;
        return $this;
    }

    /**
     * Physical address of the item.
     *
     * @var PostalAddress|string
     */
    private $_address;

    /**
     * @return PostalAddress|string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param PostalAddress|string $address
     * @return PlaceTrait
     */
    public function setAddress($address)
    {
        $this->_address = $address;
        return $this;
    }

    /**
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @var AggregateRating
     */
    private $_aggregateRating;

    /**
     * @return AggregateRating
     */
    public function getAggregateRating()
    {
        return $this->_aggregateRating;
    }

    /**
     * @param AggregateRating $aggregateRating
     * @return PlaceTrait
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;
        return $this;
    }

    /**
     * An amenity feature (e.g. a characteristic or service) of the Accommodation.
     * This generic property does not make a statement about whether the feature is included in an offer
     * for the main accommodation or available at extra costs.
     *
     * @var LocationFeatureSpecification
     */
    private $_amenityFeature;

    /**
     * @return LocationFeatureSpecification
     */
    public function getAmenityFeature()
    {
        return $this->_amenityFeature;
    }

    /**
     * @param LocationFeatureSpecification $amenityFeature
     * @return PlaceTrait
     */
    public function setAmenityFeature($amenityFeature)
    {
        $this->_amenityFeature = $amenityFeature;
        return $this;
    }

    /**
     * A short textual code (also called "store code") that uniquely identifies a place of business.
     * The code is typically assigned by the parentOrganization and used in structured URLs.
     * For example, in the URL http://www.starbucks.co.uk/store-locator/etc/detail/3047
     * the code "3047" is a branchCode for a particular branch.
     *
     * @var string
     */
    private $_branchCode;

    /**
     * @return string
     */
    public function getBranchCode()
    {
        return $this->_branchCode;
    }

    /**
     * @param string $branchCode
     * @return PlaceTrait
     */
    public function setBranchCode($branchCode)
    {
        $this->_branchCode = $branchCode;
        return $this;
    }

    /**
     * The basic containment relation between a place and one that contains it.
     * Supersedes containedIn.
     * Inverse property: containsPlace.
     *
     * @var Place
     */
    private $_containedInPlace;

    /**
     * @return Place
     */
    public function getContainedInPlace()
    {
        return $this->_containedInPlace;
    }

    /**
     * @param Place $containedInPlace
     * @return PlaceTrait
     */
    public function setContainedInPlace($containedInPlace)
    {
        $this->_containedInPlace = $containedInPlace;
        return $this;
    }

    /**
     * The basic containment relation between a place and another that it contains.
     * Inverse property: containedInPlace.
     *
     * @var Place
     */
    private $_containsPlace;

    /**
     * @return Place
     */
    public function getContainsPlace()
    {
        return $this->_containsPlace;
    }

    /**
     * @param Place $containsPlace
     * @return PlaceTrait
     */
    public function setContainsPlace($containsPlace)
    {
        $this->_containsPlace = $containsPlace;
        return $this;
    }

    /**
     * Upcoming or past event associated with this place, organization, or action.
     * Supersedes events.
     *
     * @var Event
     */
    private $_event;

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->_event;
    }

    /**
     * @param Event $event
     * @return PlaceTrait
     */
    public function setEvent($event)
    {
        $this->_event = $event;
        return $this;
    }

    /**
     * The fax number.
     *
     * @var string
     */
    private $_faxNumber;

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }

    /**
     * @param string $faxNumber
     * @return PlaceTrait
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber = $faxNumber;
        return $this;
    }

    /**
     * The geo coordinates of the place.
     *
     * @var GeoCoordinates|GeoShape
     */
    private $_geo;

    /**
     * @return GeoCoordinates|GeoShape
     */
    public function getGeo()
    {
        return $this->_geo;
    }

    /**
     * @param GeoCoordinates|GeoShape $geo
     * @return PlaceTrait
     */
    public function setGeo($geo)
    {
        $this->_geo = $geo;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a containing geometry
     * to a contained geometry. "a contains b iff no points of b lie in the exterior of a, and at least one point
     * of the interior of b lies in the interior of a". As defined in DE-9IM.
     *
     * @var
     */
    private $_geospatiallyContains;

    /**
     * @return mixed
     */
    public function getGeospatiallyContains()
    {
        return $this->_geospatiallyContains;
    }

    /**
     * @param mixed $geospatiallyContains
     * @return PlaceTrait
     */
    public function setGeospatiallyContains($geospatiallyContains)
    {
        $this->_geospatiallyContains = $geospatiallyContains;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent),
     * relating a geometry to another that covers it. As defined in DE-9IM.
     *
     * @var
     */
    private $_geospatiallyCoveredBy;

    /**
     * @return mixed
     */
    public function getGeospatiallyCoveredBy()
    {
        return $this->_geospatiallyCoveredBy;
    }

    /**
     * @param mixed $geospatiallyCoveredBy
     * @return PlaceTrait
     */
    public function setGeospatiallyCoveredBy($geospatiallyCoveredBy)
    {
        $this->_geospatiallyCoveredBy = $geospatiallyCoveredBy;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a covering geometry
     * to a covered geometry. "Every point of b is a point of (the interior or boundary of) a". As defined in DE-9IM.
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyCovers;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCovers()
    {
        return $this->_geospatiallyCovers;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyCovers
     * @return PlaceTrait
     */
    public function setGeospatiallyCovers($geospatiallyCovers)
    {
        $this->_geospatiallyCovers = $geospatiallyCovers;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry to another
     * that crosses it: "a crosses b: they have some but not all interior points in common, and the dimension of the
     * intersection is less than that of at least one of them". As defined in DE-9IM.
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyCrosses;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCrosses()
    {
        return $this->_geospatiallyCrosses;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyCrosses
     * @return PlaceTrait
     */
    public function setGeospatiallyCrosses($geospatiallyCrosses)
    {
        $this->_geospatiallyCrosses = $geospatiallyCrosses;
        return $this;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) are topologically disjoint:
     * they have no point in common. They form a set of disconnected geometries."
     * (a symmetric relationship, as defined in DE-9IM)
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyDisjoint;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyDisjoint()
    {
        return $this->_geospatiallyDisjoint;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyDisjoint
     * @return PlaceTrait
     */
    public function setGeospatiallyDisjoint($geospatiallyDisjoint)
    {
        $this->_geospatiallyDisjoint = $geospatiallyDisjoint;
        return $this;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) are topologically equal,
     * as defined in DE-9IM. "Two geometries are topologically equal if their interiors intersect and no part
     * of the interior or boundary of one geometry intersects the exterior of the other" (a symmetric relationship)
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyEquals;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyEquals()
    {
        return $this->_geospatiallyEquals;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyEquals
     * @return PlaceTrait
     */
    public function setGeospatiallyEquals($geospatiallyEquals)
    {
        $this->_geospatiallyEquals = $geospatiallyEquals;
        return $this;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) have at least one point
     * in common. As defined in DE-9IM.
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyIntersects;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyIntersects()
    {
        return $this->_geospatiallyIntersects;
    }

    /**
     * @param mixed $geospatiallyIntersects
     * @return PlaceTrait
     */
    public function setGeospatiallyIntersects($geospatiallyIntersects)
    {
        $this->_geospatiallyIntersects = $geospatiallyIntersects;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry
     * to another that geospatially overlaps it, i.e. they have some but not all points in common. As defined in DE-9IM.
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyOverlaps;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyOverlaps()
    {
        return $this->_geospatiallyOverlaps;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyOverlaps
     * @return PlaceTrait
     */
    public function setGeospatiallyOverlaps($geospatiallyOverlaps)
    {
        $this->_geospatiallyOverlaps = $geospatiallyOverlaps;
        return $this;
    }

    /**
     * Represents spatial relations in which two geometries (or the places they represent) touch: they have
     * at least one boundary point in common, but no interior points." (a symmetric relationship, as defined in DE-9IM )
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyTouches;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyTouches()
    {
        return $this->_geospatiallyTouches;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyTouches
     * @return PlaceTrait
     */
    public function setGeospatiallyTouches($geospatiallyTouches)
    {
        $this->_geospatiallyTouches = $geospatiallyTouches;
        return $this;
    }

    /**
     * Represents a relationship between two geometries (or the places they represent), relating a geometry to one
     * that contains it, i.e. it is inside (i.e. within) its interior. As defined in DE-9IM.
     *
     * @var GeospatialGeometry|Place
     */
    private $_geospatiallyWithin;

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyWithin()
    {
        return $this->_geospatiallyWithin;
    }

    /**
     * @param GeospatialGeometry|Place $geospatiallyWithin
     * @return PlaceTrait
     */
    public function setGeospatiallyWithin($geospatiallyWithin)
    {
        $this->_geospatiallyWithin = $geospatiallyWithin;
        return $this;
    }

    /**
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties
     * and physical locations.
     *
     * @var string
     */
    private $_globalLocationNumber;

    /**
     * @return string
     */
    public function getGlobalLocationNumber()
    {
        return $this->_globalLocationNumber;
    }

    /**
     * @param string $globalLocationNumber
     * @return PlaceTrait
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->_globalLocationNumber = $globalLocationNumber;
        return $this;
    }

    /**
     * A URL to a map of the place.
     * Supersedes map, maps.
     *
     * @var Map, URL
     */
    private $_hasMap;

    /**
     * @return Map
     */
    public function getHasMap()
    {
        return $this->_hasMap;
    }

    /**
     * @param Map $hasMap
     * @return PlaceTrait
     */
    public function setHasMap($hasMap)
    {
        $this->_hasMap = $hasMap;
        return $this;
    }

    /**
     * A flag to signal that the item, event, or place is accessible for free.
     * Supersedes free.
     *
     * @var Boolean
     */
    private $_isAccessibleForFree;

    /**
     * @return bool
     */
    public function isAccessibleForFree()
    {
        return $this->_isAccessibleForFree;
    }

    /**
     * @param bool $isAccessibleForFree
     * @return PlaceTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    /**
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @var string
     */
    private $_isicV4;

    /**
     * @return string
     */
    public function getIsicV4()
    {
        return $this->_isicV4;
    }

    /**
     * @param string $isicV4
     * @return PlaceTrait
     */
    public function setIsicV4($isicV4)
    {
        $this->_isicV4 = $isicV4;
        return $this;
    }

    /**
     * An associated logo.
     *
     * @var ImageObject|URL
     */
    private $_logo;

    /**
     * @return ImageObject|URL
     */
    public function getLogo()
    {
        return $this->_logo;
    }

    /**
     * @param ImageObject|URL $logo
     * @return PlaceTrait
     */
    public function setLogo($logo)
    {
        $this->_logo = $logo;
        return $this;
    }

    /**
     * The total number of individuals that may attend an event or venue.
     *
     * @var Integer
     */
    private $_maximumAttendeeCapacity;

    /**
     * @return int
     */
    public function getMaximumAttendeeCapacity()
    {
        return $this->_maximumAttendeeCapacity;
    }

    /**
     * @param int $maximumAttendeeCapacity
     * @return PlaceTrait
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity)
    {
        $this->_maximumAttendeeCapacity = $maximumAttendeeCapacity;
        return $this;
    }

    /**
     * The opening hours of a certain place.
     *
     * @var OpeningHoursSpecification
     */
    private $_openingHoursSpecification;

    /**
     * @return OpeningHoursSpecification
     */
    public function getOpeningHoursSpecification()
    {
        return $this->_openingHoursSpecification;
    }

    /**
     * @param OpeningHoursSpecification $openingHoursSpecification
     * @return PlaceTrait
     */
    public function setOpeningHoursSpecification($openingHoursSpecification)
    {
        $this->_openingHoursSpecification = $openingHoursSpecification;
        return $this;
    }

    /**
     * A photograph of this place. Supersedes photos.
     *
     * @var ImageObject|Photograph
     */
    private $_photo;

    /**
     * @return ImageObject|Photograph
     */
    public function getPhoto()
    {
        return $this->_photo;
    }

    /**
     * @param ImageObject|Photograph $photo
     * @return PlaceTrait
     */
    public function setPhoto($photo)
    {
        $this->_photo = $photo;
        return $this;
    }

    /**
     * A flag to signal that the Place is open to public visitors.
     * If this property is omitted there is no assumed default boolean value
     *
     * @var Boolean
     */
    private $_publicAccess;

    /**
     * @return bool
     */
    public function isPublicAccess()
    {
        return $this->_publicAccess;
    }

    /**
     * @param bool $publicAccess
     * @return PlaceTrait
     */
    public function setPublicAccess($publicAccess)
    {
        $this->_publicAccess = $publicAccess;
        return $this;
    }

    /**
     * A review of the item. Supersedes reviews.
     *
     * @var Review
     */
    private $_review;

    /**
     * @return Review
     */
    public function getReview()
    {
        return $this->_review;
    }

    /**
     * @param Review $review
     * @return PlaceTrait
     */
    public function setReview($review)
    {
        $this->_review = $review;
        return $this;
    }

    /**
     * Indicates whether it is allowed to smoke in the place, e.g. in the restaurant, hotel or hotel room.
     *
     * @var Boolean
     */
    private $_smokingAllowed;

    /**
     * @return bool
     */
    public function isSmokingAllowed()
    {
        return $this->_smokingAllowed;
    }

    /**
     * @param bool $smokingAllowed
     * @return PlaceTrait
     */
    public function setSmokingAllowed($smokingAllowed)
    {
        $this->_smokingAllowed = $smokingAllowed;
        return $this;
    }

    /**
     * The special opening hours of a certain place.
     * Use this to explicitly override general opening hours brought in scope by
     * openingHoursSpecification or openingHours.
     *
     * @var OpeningHoursSpecification
     */
    private $_specialOpeningHoursSpecification;

    /**
     * @return OpeningHoursSpecification
     */
    public function getSpecialOpeningHoursSpecification()
    {
        return $this->_specialOpeningHoursSpecification;
    }

    /**
     * @param OpeningHoursSpecification $specialOpeningHoursSpecification
     * @return PlaceTrait
     */
    public function setSpecialOpeningHoursSpecification($specialOpeningHoursSpecification)
    {
        $this->_specialOpeningHoursSpecification = $specialOpeningHoursSpecification;
        return $this;
    }

    /**
     * The telephone number.
     *
     * @var string
     */
    private $_telephone;

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * @param string $telephone
     * @return PlaceTrait
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        return $this;
    }
}