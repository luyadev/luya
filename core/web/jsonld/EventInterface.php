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
    public function setAbout(Thing $about);

    /**
     * @return Person
     */
    public function getActor();

    /**
     * @param Person $actor
     * @return EventTrait
     */
    public function setActor(Person $actor);

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
    public function setDirector(Person $director);

    /**
     * @return string
     */
    public function getDoorTime();

    /**
     * @param DateTimeValue $doorTime
     * @return EventTrait
     */
    public function setDoorTime(DateTimeValue $doorTime);

    /**
     * @return string
     */
    public function getDuration();

    /**
     * @param DurationValue $duration
     * @return EventTrait
     */
    public function setDuration(DurationValue $duration);

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @param DateTimeValue $endDate
     * @return EventTrait
     */
    public function setEndDate(DateTimeValue $endDate);

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
     * @return string
     */
    public function getPreviousStartDate();

    /**
     * @param DateValue $previousStartDate
     * @return EventTrait
     */
    public function setPreviousStartDate(DateValue $previousStartDate);

    /**
     * @return CreativeWork
     */
    public function getRecordedIn();

    /**
     * @param CreativeWork $recordedIn
     * @return EventTrait
     */
    public function setRecordedIn(CreativeWork $recordedIn);

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
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return EventTrait
     */
    public function setSponsor($sponsor);

    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @param DateTimeValue $startDate
     * @return EventTrait
     */
    public function setStartDate(DateTimeValue $startDate);

    /**
     * @return Event
     */
    public function getSubEvent();

    /**
     * @param Event $subEvent
     */
    public function setSubEvent(Event $subEvent);

    /**
     * @return Event
     */
    public function getSuperEvent();

    /**
     * @param Event $superEvent
     * @return EventTrait
     */
    public function setSuperEvent(Event $superEvent);

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
    public function setWorkFeatured(CreativeWork $workFeatured);

    /**
     * @return CreativeWork
     */
    public function getWorkPerformed();

    /**
     * @param CreativeWork $workPerformed
     * @return EventTrait
     */
    public function setWorkPerformed(CreativeWork $workPerformed);
}
