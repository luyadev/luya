<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Event trait
 *
 * @see http://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait EventTrait
{
    private $_about;

    /**
     * @return Thing
     */
    public function getAbout()
    {
        return $this->_about;
    }

    /**
     * The subject matter of the content.
     * Inverse property: subjectOf.
     *
     * @param Thing $about
     * @return EventTrait
     */
    public function setAbout($about)
    {
        $this->_about = $about;
        return $this;
    }

    private $_actor;

    /**
     * @return Person
     */
    public function getActor()
    {
        return $this->_actor;
    }

    /**
     * An actor, e.g. in tv, radio, movie, video games etc., or in an event.
     * Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.
     *
     * @param Person $actor
     * @return EventTrait
     */
    public function setActor($actor)
    {
        $this->_actor = $actor;
        return $this;
    }

    private $_attendee;

    /**
     * @return Organization|Person
     */
    public function getAttendee()
    {
        return $this->_attendee;
    }

    /**
     * A person or organization attending the event. Supersedes attendees.
     *
     * @param Organization|Person $attendee
     * @return EventTrait
     */
    public function setAttendee($attendee)
    {
        $this->_attendee = $attendee;
        return $this;
    }

    private $_composer;

    /**
     * @return Organization|Person
     */
    public function getComposer()
    {
        return $this->_composer;
    }

    /**
     * The person or organization who wrote a composition, or who is the composer of a work performed at some event.
     *
     * @param Organization|Person $composer
     * @return EventTrait
     */
    public function setComposer($composer)
    {
        $this->_composer = $composer;
        return $this;
    }

    private $_contributor;

    /**
     * @return Organization|Person
     */
    public function getContributor()
    {
        return $this->_contributor;
    }

    /**
     * A secondary contributor to the CreativeWork or Event.
     *
     * @param Organization|Person $contributor
     * @return EventTrait
     */
    public function setContributor($contributor)
    {
        $this->_contributor = $contributor;
        return $this;
    }

    private $_director;

    /**
     * @return Person
     */
    public function getDirector()
    {
        return $this->_director;
    }

    /**
     * A director of e.g. tv, radio, movie, video gaming etc. content, or of an event.
     * Directors can be associated with individual items or with a series, episode, clip.
     * Supersedes directors.
     *
     * @param Person $director
     * @return EventTrait
     */
    public function setDirector($director)
    {
        $this->_director = $director;
        return $this;
    }

    private $_doorTime;

    /**
     * @return DateTime
     */
    public function getDoorTime()
    {
        return $this->_doorTime;
    }

    /**
     * The time admission will commence.
     *
     * @param DateTime $doorTime
     * @return EventTrait
     */
    public function setDoorTime($doorTime)
    {
        $this->_doorTime = $doorTime;
        return $this;
    }

    private $_duration;

    /**
     * @return Duration
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.
     *
     * @param Duration $duration
     * @return EventTrait
     */
    public function setDuration($duration)
    {
        $this->_duration = $duration;
        return $this;
    }

    private $_endDate;

    /**
     * @return Date|DateTime
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }

    /**
     * The end date and time of the item (in ISO 8601 date format).
     *
     * @param Date|DateTime $endDate
     * @return EventTrait
     */
    public function setEndDate($endDate)
    {
        $this->_endDate = $endDate;
        return $this;
    }

    private $_funder;

    /**
     * @return Organization|Person
     */
    public function getFunder()
    {
        return $this->_funder;
    }

    /**
     * A person or organization that supports (sponsors) something through some kind of financial contribution.
     *
     * @param Organization|Person $funder
     * @return EventTrait
     */
    public function setFunder($funder)
    {
        $this->_funder = $funder;
        return $this;
    }

    private $_inLanguage;

    /**
     * @return Language|Text
     */
    public function getInLanguage()
    {
        return $this->_inLanguage;
    }

    /**
     * The language of the content or performance or used in an action.
     * Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.
     * Supersedes language.
     *
     * @param Language|Text $inLanguage
     * @return EventTrait
     */
    public function setInLanguage($inLanguage)
    {
        $this->_inLanguage = $inLanguage;
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
     * A flag to signal that the item, event, or place is accessible for free. Supersedes free.
     *
     * @param bool $isAccessibleForFree
     * @return EventTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    private $_location;

    /**
     * @return Place|PostalAddress|string
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * The location of for example where the event is happening, an organization is located,
     * or where an action takes place.
     *
     * @param Place|PostalAddress|string $location
     * @return EventTrait
     */
    public function setLocation($location)
    {
        $this->_location = $location;
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
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity)
    {
        $this->_maximumAttendeeCapacity = $maximumAttendeeCapacity;
    }

    private $_organizer;

    /**
     * @return Organization|Person
     */
    public function getOrganizer()
    {
        return $this->_organizer;
    }

    /**
     * An organizer of an Event.
     *
     * @param Organization|Person $organizer
     * @return EventTrait
     */
    public function setOrganizer($organizer)
    {
        $this->_organizer = $organizer;
        return $this;
    }

    private $_performer;

    /**
     * @return Organization|Person
     */
    public function getPerformer()
    {
        return $this->_performer;
    }

    /**
     * A performer at the event—for example, a presenter, musician, musical group or actor.
     * Supersedes performers.
     *
     * @param Organization|Person $performer
     * @return EventTrait
     */
    public function setPerformer($performer)
    {
        $this->_performer = $performer;
        return $this;
    }

    private $_previousStartDate;

    /**
     * @return string
     */
    public function getPreviousStartDate()
    {
        return $this->_previousStartDate;
    }

    /**
     * Used in conjunction with eventStatus for rescheduled or cancelled events.
     * This property contains the previously scheduled start date.
     * For rescheduled events, the startDate property should be used for the newly scheduled start date.
     * In the (rare) case of an event that has been postponed and rescheduled multiple times,
     * this field may be repeated.
     *
     * @param DateValue $previousStartDate
     * @return EventTrait
     */
    public function setPreviousStartDate(DateValue $previousStartDate)
    {
        $this->_previousStartDate = $previousStartDate;
        return $this;
    }

    private $_recordedIn;

    /**
     * @return CreativeWork
     */
    public function getRecordedIn()
    {
        return $this->_recordedIn;
    }

    /**
     * The CreativeWork that captured all or part of this Event.
     * Inverse property: recordedAt
     *
     * @param CreativeWork $recordedIn
     * @return EventTrait
     */
    public function setRecordedIn(CreativeWork $recordedIn)
    {
        $this->_recordedIn = $recordedIn;
        return $this;
    }

    private $_remainingAttendeeCapacity;

    /**
     * @return int
     */
    public function getRemainingAttendeeCapacity()
    {
        return $this->_remainingAttendeeCapacity;
    }

    /**
     * The number of attendee places for an event that remain unallocated.
     *
     * @param int $remainingAttendeeCapacity
     * @return EventTrait
     */
    public function setRemainingAttendeeCapacity($remainingAttendeeCapacity)
    {
        $this->_remainingAttendeeCapacity = $remainingAttendeeCapacity;
        return $this;
    }

    private $_sponsor;

    /**
     * @return Organization|Person
     */
    public function getSponsor()
    {
        return $this->_sponsor;
    }

    /**
     * A person or organization that supports a thing through a pledge, promise, or financial contribution.
     * e.g. a sponsor of a Medical Study or a corporate sponsor of an event.
     *
     * @param Organization|Person $sponsor
     * @return EventTrait
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor = $sponsor;
        return $this;
    }

    private $_startDate;

    /**
     * @return Date|DateTime
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * The start date and time of the item (in ISO 8601 date format).
     *
     * @param DateTimeValue $startDate
     * @return EventTrait
     */
    public function setStartDate(DateTimeValue $startDate)
    {
        $this->_startDate = $startDate;
        return $this;
    }

    private $_subEvent;

    /**
     * @return Event
     */
    public function getSubEvent()
    {
        return $this->_subEvent;
    }

    /**
     * An Event that is part of this event.
     * For example, a conference event includes many presentations, each of which is a subEvent of the conference.
     * Supersedes subEvents.
     * Inverse property: superEvent.
     *
     * @param Event $subEvent
     */
    public function setSubEvent(Event $subEvent)
    {
        $this->_subEvent = $subEvent;
    }

    private $_superEvent;

    /**
     * @return Event
     */
    public function getSuperEvent()
    {
        return $this->_superEvent;
    }

    /**
     * An event that this event is a part of.
     * For example, a collection of individual music performances might each have a music festival as their superEvent.
     * Inverse property: subEvent.
     *
     * @param Event $superEvent
     * @return EventTrait
     */
    public function setSuperEvent(Event $superEvent)
    {
        $this->_superEvent = $superEvent;
        return $this;
    }

    private $_translator;

    /**
     * @return Organization|Person
     */
    public function getTranslator()
    {
        return $this->_translator;
    }

    /**
     * Organization or person who adapts a creative work to different languages, regional differences
     * and technical requirements of a target market, or that translates during some event.
     *
     * @param Organization|Person $translator
     * @return EventTrait
     */
    public function setTranslator($translator)
    {
        $this->_translator = $translator;
        return $this;
    }

    private $_typicalAgeRange;

    /**
     * @return string
     */
    public function getTypicalAgeRange()
    {
        return $this->_typicalAgeRange;
    }

    /**
     * The typical expected age range, e.g. '7-9', '11-'.
     *
     * @param string $typicalAgeRange
     * @return EventTrait
     */
    public function setTypicalAgeRange($typicalAgeRange)
    {
        $this->_typicalAgeRange = $typicalAgeRange;
        return $this;
    }

    private $_workFeatured;

    /**
     * @return CreativeWork
     */
    public function getWorkFeatured()
    {
        return $this->_workFeatured;
    }

    /**
     * A work featured in some event, e.g. exhibited in an ExhibitionEvent.
     * Specific subproperties are available for workPerformed (e.g. a play),
     * or a workPresented (a Movie at a ScreeningEvent).
     *
     * @param CreativeWork $workFeatured
     * @return EventTrait
     */
    public function setWorkFeatured(CreativeWork $workFeatured)
    {
        $this->_workFeatured = $workFeatured;
        return $this;
    }

    private $_workPerformed;

    /**
     * @return CreativeWork
     */
    public function getWorkPerformed()
    {
        return $this->_workPerformed;
    }

    /**
     * A work performed in some event, for example a play performed in a TheaterEvent.
     *
     * @param CreativeWork $workPerformed
     * @return EventTrait
     */
    public function setWorkPerformed(CreativeWork $workPerformed)
    {
        $this->_workPerformed = $workPerformed;
        return $this;
    }
}
