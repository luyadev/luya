<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Place interface
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
interface PlaceInterface
{
    /**
     * @return PropertyValue
     */
    public function getAdditionalProperty();

    /**
     * @param PropertyValue $additionalProperty
     * @return static
     */
    public function setAdditionalProperty(PropertyValue $additionalProperty);

    /**
     * @return PostalAddress|string
     */
    public function getAddress();

    /**
     * @param PostalAddress|string $address
     * @return static
     */
    public function setAddress(PostalAddress $address);

    /**
     * @return AggregateRating
     */
    public function getAggregateRating();

    /**
     * @param AggregateRating $aggregateRating
     * @return static
     */
    public function setAggregateRating(AggregateRating $aggregateRating);

    /**
     * @return LocationFeatureSpecification
     */
    public function getAmenityFeature();

    /**
     * @param LocationFeatureSpecification $amenityFeature
     * @return static
     */
    public function setAmenityFeature($amenityFeature);

    /**
     * @return string
     */
    public function getBranchCode();

    /**
     * @param string $branchCode
     * @return static
     */
    public function setBranchCode($branchCode);

    /**
     * @return Place
     */
    public function getContainedInPlace();

    /**
     * @param Place $containedInPlace
     * @return static
     */
    public function setContainedInPlace(Place $containedInPlace);

    /**
     * @return Place
     */
    public function getContainsPlace();

    /**
     * @param Place $containsPlace
     * @return static
     */
    public function setContainsPlace(Place $containsPlace);

    /**
     * @return Event
     */
    public function getEvent();

    /**
     * @param Event $event
     * @return static
     */
    public function setEvent(Event $event);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param string $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return GeoCoordinates|GeoShape
     */
    public function getGeo();

    /**
     * @param GeoCoordinates|GeoShape $geo
     * @return static
     */
    public function setGeo($geo);

    /**
     * @return mixed
     */
    public function getGeospatiallyContains();

    /**
     * @param mixed $geospatiallyContains
     * @return static
     */
    public function setGeospatiallyContains($geospatiallyContains);

    /**
     * @return mixed
     */
    public function getGeospatiallyCoveredBy();

    /**
     * @param mixed $geospatiallyCoveredBy
     * @return static
     */
    public function setGeospatiallyCoveredBy($geospatiallyCoveredBy);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCovers();

    /**
     * @param GeospatialGeometry|Place $geospatiallyCovers
     * @return static
     */
    public function setGeospatiallyCovers($geospatiallyCovers);
    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyCrosses();

    /**
     * @param GeospatialGeometry|Place $geospatiallyCrosses
     * @return static
     */
    public function setGeospatiallyCrosses($geospatiallyCrosses);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyDisjoint();

    /**
     * @param GeospatialGeometry|Place $geospatiallyDisjoint
     * @return static
     */
    public function setGeospatiallyDisjoint($geospatiallyDisjoint);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyEquals();

    /**
     * @param GeospatialGeometry|Place $geospatiallyEquals
     * @return static
     */
    public function setGeospatiallyEquals($geospatiallyEquals);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyIntersects();

    /**
     * @param mixed $geospatiallyIntersects
     * @return static
     */
    public function setGeospatiallyIntersects($geospatiallyIntersects);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyOverlaps();

    /**
     * @param GeospatialGeometry|Place $geospatiallyOverlaps
     * @return static
     */
    public function setGeospatiallyOverlaps($geospatiallyOverlaps);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyTouches();

    /**
     * @param GeospatialGeometry|Place $geospatiallyTouches
     * @return static
     */
    public function setGeospatiallyTouches($geospatiallyTouches);

    /**
     * @return GeospatialGeometry|Place
     */
    public function getGeospatiallyWithin();

    /**
     * @param GeospatialGeometry|Place $geospatiallyWithin
     * @return static
     */
    public function setGeospatiallyWithin($geospatiallyWithin);

    /**
     * @return string
     */
    public function getGlobalLocationNumber();

    /**
     * @param string $globalLocationNumber
     * @return static
     */
    public function setGlobalLocationNumber($globalLocationNumber);

    /**
     * @return Map
     */
    public function getHasMap();

    /**
     * @param Map $hasMap
     * @return static
     */
    public function setHasMap($hasMap);

    /**
     * @return bool
     */
    public function isAccessibleForFree();

    /**
     * @param bool $isAccessibleForFree
     * @return static
     */
    public function setIsAccessibleForFree($isAccessibleForFree);

    /**
     * @return string
     */
    public function getIsicV4();

    /**
     * @param string $isicV4
     * @return static
     */
    public function setIsicV4($isicV4);

    /**
     * @return ImageObject
     */
    public function getLogo();

    /**
     * @param ImageObject $logo
     * @return static
     */
    public function setLogo(ImageObject $logo);

    /**
     * @return int
     */
    public function getMaximumAttendeeCapacity();

    /**
     * @param int $maximumAttendeeCapacity
     * @return static
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity);

    /**
     * @return OpeningHoursSpecification
     */
    public function getOpeningHoursSpecification();

    /**
     * @param OpeningHoursSpecification $openingHoursSpecification
     * @return static
     */
    public function setOpeningHoursSpecification($openingHoursSpecification);

    /**
     * @return ImageObject|Photograph
     */
    public function getPhoto();

    /**
     * @param ImageObject|Photograph $photo
     * @return static
     */
    public function setPhoto($photo);

    /**
     * @return bool
     */
    public function isPublicAccess();

    /**
     * @param bool $publicAccess
     * @return static
     */
    public function setPublicAccess($publicAccess);
    /**
     * @return Review
     */
    public function getReview();

    /**
     * @param Review $review
     * @return static
     */
    public function setReview($review);
    /**
     * @return bool
     */
    public function isSmokingAllowed();

    /**
     * @param bool $smokingAllowed
     * @return static
     */
    public function setSmokingAllowed($smokingAllowed);

    /**
     * @return OpeningHoursSpecification
     */
    public function getSpecialOpeningHoursSpecification();

    /**
     * @param OpeningHoursSpecification $specialOpeningHoursSpecification
     * @return static
     */
    public function setSpecialOpeningHoursSpecification($specialOpeningHoursSpecification);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param string $telephone
     * @return static
     */
    public function setTelephone($telephone);
}
