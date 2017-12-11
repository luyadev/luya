<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Event interface
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
interface EventInterface
{
    /**
     * @return Thing
     */
    public function getAbout();

    /**
     * @param Thing $about
     * @return EventTrait
     */
    public function setAbout($about);

    /**
     * @return Person
     */
    public function getActor();

    /**
     * @param Person $actor
     * @return EventTrait
     */
    public function setActor($actor);

    /**
     * @return AggregateRating
     */
    public function getAggregateRating();

    /**
     * @param AggregateRating $aggregateRating
     * @return EventTrait
     */
    public function setAggregateRating($aggregateRating);

    /**
     * @return Organization|Person
     */
    public function getAttendee();

    /**
     * @param Organization|Person $attendee
     * @return EventTrait
     */
    public function setAttendee($attendee);

    /**
     * @return Audience
     */
    public function getAudience();

    /**
     * @param Audience $audience
     * @return EventTrait
     */
    public function setAudience($audience);

    /**
     * @return Organization|Person
     */
    public function getComposer();

    /**
     * @param Organization|Person $composer
     * @return EventTrait
     */
    public function setComposer($composer);

    /**
     * @return Organization|Person
     */
    public function getContributor();

    /**
     * @param Organization|Person $contributor
     * @return EventTrait
     */
    public function setContributor($contributor);

    /**
     * @return Person
     */
    public function getDirector();

    /**
     * @param Person $director
     * @return EventTrait
     */
    public function setDirector($director);

    /**
     * @return DateTime
     */
    public function getDoorTime();

    /**
     * @param DateTime $doorTime
     * @return EventTrait
     */
    public function setDoorTime($doorTime);

    /**
     * @return Duration
     */
    public function getDuration();

    /**
     * @param Duration $duration
     * @return EventTrait
     */
    public function setDuration($duration);

    /**
     * @return Date|DateTime
     */
    public function getEndDate();

    /**
     * @param Date|DateTime $endDate
     * @return EventTrait
     */
    public function setEndDate($endDate);

    /**
     * @return EventStatusType
     */
    public function getEventStatus();

    /**
     * @param EventStatusType $eventStatus
     * @return EventTrait
     */
    public function setEventStatus($eventStatus);

    /**
     * @return Organization|Person
     */
    public function getFunder();

    /**
     * @param Organization|Person $funder
     * @return EventTrait
     */
    public function setFunder($funder);

    /**
     * @return Language|Text
     */
    public function getInLanguage();

    /**
     * @param Language|Text $inLanguage
     * @return EventTrait
     */
    public function setInLanguage($inLanguage);

    /**
     * @return bool
     */
    public function isAccessibleForFree();

    /**
     * @param bool $isAccessibleForFree
     * @return EventTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree);

    /**
     * @return Place|PostalAddress|string
     */
    public function getLocation();

    /**
     * @param Place|PostalAddress|string $location
     * @return EventTrait
     */
    public function setLocation($location);

    /**
     * @return int
     */
    public function getMaximumAttendeeCapacity();

    /**
     * @param int $maximumAttendeeCapacity
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity);

    /**
     * @return Offer
     */
    public function getOffers();

    /**
     * @param Offer $offers
     * @return EventTrait
     */
    public function setOffers($offers);

    /**
     * @return Organization|Person
     */
    public function getOrganizer();

    /**
     * @param Organization|Person $organizer
     * @return EventTrait
     */
    public function setOrganizer($organizer);

    /**
     * @return Organization|Person
     */
    public function getPerformer();

    /**
     * @param Organization|Person $performer
     * @return EventTrait
     */
    public function setPerformer($performer);

    /**
     * @return Date
     */
    public function getPreviousStartDate();

    /**
     * @param Date $previousStartDate
     * @return EventTrait
     */
    public function setPreviousStartDate($previousStartDate);

    /**
     * @return CreativeWork
     */
    public function getRecordedIn();

    /**
     * @param CreativeWork $recordedIn
     * @return EventTrait
     */
    public function setRecordedIn($recordedIn);

    /**
     * @return int
     */
    public function getRemainingAttendeeCapacity();

    /**
     * @param int $remainingAttendeeCapacity
     * @return EventTrait
     */
    public function setRemainingAttendeeCapacity($remainingAttendeeCapacity);

    /**
     * @return Review
     */
    public function getReview();

    /**
     * @param Review $review
     * @return EventTrait
     */
    public function setReview($review);

    /**
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return EventTrait
     */
    public function setSponsor($sponsor);

    /**
     * @return Date|DateTime
     */
    public function getStartDate();

    /**
     * @param Date|DateTime $startDate
     * @return EventTrait
     */
    public function setStartDate($startDate);

    /**
     * @return Event
     */
    public function getSubEvent();

    /**
     * @param Event $subEvent
     */
    public function setSubEvent($subEvent);

    /**
     * @return Event
     */
    public function getSuperEvent();

    /**
     * @param Event $superEvent
     * @return EventTrait
     */
    public function setSuperEvent($superEvent);

    /**
     * @return Organization|Person
     */
    public function getTranslator();

    /**
     * @param Organization|Person $translator
     * @return EventTrait
     */
    public function setTranslator($translator);

    /**
     * @return string
     */
    public function getTypicalAgeRange();

    /**
     * @param string $typicalAgeRange
     * @return EventTrait
     */
    public function setTypicalAgeRange($typicalAgeRange);

    /**
     * @return CreativeWork
     */
    public function getWorkFeatured();

    /**
     * @param CreativeWork $workFeatured
     * @return EventTrait
     */
    public function setWorkFeatured($workFeatured);

    /**
     * @return CreativeWork
     */
    public function getWorkPerformed();

    /**
     * @param CreativeWork $workPerformed
     * @return EventTrait
     */
    public function setWorkPerformed($workPerformed);
}
