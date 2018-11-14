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
     * @return static
     */
    public function setAbout(Thing $about);

    /**
     * @return Person
     */
    public function getActor();

    /**
     * @param Person $actor
     * @return static
     */
    public function setActor(Person $actor);

    /**
     * @return Organization|Person
     */
    public function getAttendee();

    /**
     * @param Organization|Person $attendee
     * @return static
     */
    public function setAttendee($attendee);

    /**
     * @return Organization|Person
     */
    public function getComposer();

    /**
     * @param Organization|Person $composer
     * @return static
     */
    public function setComposer($composer);

    /**
     * @return Organization|Person
     */
    public function getContributor();

    /**
     * @param Organization|Person $contributor
     * @return static
     */
    public function setContributor($contributor);

    /**
     * @return Person
     */
    public function getDirector();

    /**
     * @param Person $director
     * @return static
     */
    public function setDirector(Person $director);

    /**
     * @return string
     */
    public function getDoorTime();

    /**
     * @param DateTimeValue $doorTime
     * @return static
     */
    public function setDoorTime(DateTimeValue $doorTime);

    /**
     * @return string
     */
    public function getDuration();

    /**
     * @param DurationValue $duration
     * @return static
     */
    public function setDuration(DurationValue $duration);

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @param DateTimeValue $endDate
     * @return static
     */
    public function setEndDate(DateTimeValue $endDate);

    /**
     * @return Organization|Person
     */
    public function getFunder();

    /**
     * @param Organization|Person $funder
     * @return static
     */
    public function setFunder($funder);

    /**
     * @return Language|Text
     */
    public function getInLanguage();

    /**
     * @param Language|Text $inLanguage
     * @return static
     */
    public function setInLanguage(LanguageValue $inLanguage);

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
     * @return Place|PostalAddress|string
     */
    public function getLocation();

    /**
     * @param Place|PostalAddress|string $location
     * @return static
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
     * @return static
     */
    public function setOrganizer($organizer);

    /**
     * @return Organization|Person
     */
    public function getPerformer();

    /**
     * @param Organization|Person $performer
     * @return static
     */
    public function setPerformer($performer);

    /**
     * @return string
     */
    public function getPreviousStartDate();

    /**
     * @param DateValue $previousStartDate
     * @return static
     */
    public function setPreviousStartDate(DateValue $previousStartDate);

    /**
     * @return CreativeWork
     */
    public function getRecordedIn();

    /**
     * @param CreativeWork $recordedIn
     * @return static
     */
    public function setRecordedIn(CreativeWork $recordedIn);

    /**
     * @return int
     */
    public function getRemainingAttendeeCapacity();

    /**
     * @param int $remainingAttendeeCapacity
     * @return static
     */
    public function setRemainingAttendeeCapacity($remainingAttendeeCapacity);

    /**
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return static
     */
    public function setSponsor($sponsor);

    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @param DateTimeValue $startDate
     * @return static
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
     * @return static
     */
    public function setSuperEvent(Event $superEvent);

    /**
     * @return Organization|Person
     */
    public function getTranslator();

    /**
     * @param Organization|Person $translator
     * @return static
     */
    public function setTranslator($translator);

    /**
     * @return string
     */
    public function getTypicalAgeRange();

    /**
     * @param string $typicalAgeRange
     * @return static
     */
    public function setTypicalAgeRange($typicalAgeRange);

    /**
     * @return CreativeWork
     */
    public function getWorkFeatured();

    /**
     * @param CreativeWork $workFeatured
     * @return static
     */
    public function setWorkFeatured(CreativeWork $workFeatured);

    /**
     * @return CreativeWork
     */
    public function getWorkPerformed();

    /**
     * @param CreativeWork $workPerformed
     * @return static
     */
    public function setWorkPerformed(CreativeWork $workPerformed);
}
