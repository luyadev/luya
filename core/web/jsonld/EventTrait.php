<?php

namespace luya\web\jsonld;

use luya\helpers\ObjectHelper;

/**
 * JsonLd - Event trait
 *
 * @see https://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait EventTrait
{
    private $_about;

    /**
     * @return static
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
     * @return static
     */
    public function setAbout(Thing $about)
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
     * @return static
     */
    public function setActor(Person $actor)
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
     * @return static
     */
    public function setAttendee($attendee)
    {
        ObjectHelper::isInstanceOf($attendee, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setComposer($composer)
    {
        ObjectHelper::isInstanceOf($composer, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setContributor($contributor)
    {
        ObjectHelper::isInstanceOf($contributor, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setDirector(Person $director)
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
     * @return static
     */
    public function setDoorTime(DateTimeValue $doorTime)
    {
        $this->_doorTime = $doorTime->getValue();
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
     * @return static
     */
    public function setDuration(DurationValue $duration)
    {
        $this->_duration = $duration->getValue();
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
     * @return static
     */
    public function setEndDate(DateTimeValue $endDate)
    {
        $this->_endDate = $endDate->getValue();
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
     * @return static
     */
    public function setFunder($funder)
    {
        ObjectHelper::isInstanceOf($funder, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setInLanguage(LanguageValue $inLanguage)
    {
        $this->_inLanguage = $inLanguage->getValue();
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setOrganizer($organizer)
    {
        ObjectHelper::isInstanceOf($organizer, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setPerformer($performer)
    {
        ObjectHelper::isInstanceOf($performer, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setPreviousStartDate(DateValue $previousStartDate)
    {
        $this->_previousStartDate = $previousStartDate->getValue();
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setSponsor($sponsor)
    {
        ObjectHelper::isInstanceOf($sponsor, [Organization::class, PersonInterface::class]);

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
     * @return static
     */
    public function setStartDate(DateTimeValue $startDate)
    {
        $this->_startDate = $startDate->getValue();
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
     * @return static
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
     * @return static
     */
    public function setTranslator($translator)
    {
        ObjectHelper::isInstanceOf($translator, [Organization::class, PersonInterface::class]);

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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setWorkPerformed(CreativeWork $workPerformed)
    {
        $this->_workPerformed = $workPerformed;
        return $this;
    }
}
