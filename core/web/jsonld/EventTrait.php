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
    /**
     * The subject matter of the content.
     * Inverse property: subjectOf.
     *
     * @var Thing
     */
    private $_about;

    /**
     * @return Thing
     */
    public function getAbout()
    {
        return $this->_about;
    }

    /**
     * @param Thing $about
     * @return EventTrait
     */
    public function setAbout($about)
    {
        $this->_about = $about;
        return $this;
    }

    /**
     * An actor, e.g. in tv, radio, movie, video games etc., or in an event.
     * Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.
     *
     * @var Person
     */
    private $_actor;

    /**
     * @return Person
     */
    public function getActor()
    {
        return $this->_actor;
    }

    /**
     * @param Person $actor
     * @return EventTrait
     */
    public function setActor($actor)
    {
        $this->_actor = $actor;
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
     * @return EventTrait
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;
        return $this;
    }

    /**
     * A person or organization attending the event. Supersedes attendees.
     *
     * @var Organization|Person
     */
    private $_attendee;

    /**
     * @return Organization|Person
     */
    public function getAttendee()
    {
        return $this->_attendee;
    }

    /**
     * @param Organization|Person $attendee
     * @return EventTrait
     */
    public function setAttendee($attendee)
    {
        $this->_attendee = $attendee;
        return $this;
    }

    /**
     * An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.
     *
     * @var Audience
     */
    private $_audience;

    /**
     * @return Audience
     */
    public function getAudience()
    {
        return $this->_audience;
    }

    /**
     * @param Audience $audience
     * @return EventTrait
     */
    public function setAudience($audience)
    {
        $this->_audience = $audience;
        return $this;
    }

    /**
     * The person or organization who wrote a composition, or who is the composer of a work performed at some event.
     *
     * @var Organization|Person
     */
    private $_composer;

    /**
     * @return Organization|Person
     */
    public function getComposer()
    {
        return $this->_composer;
    }

    /**
     * @param Organization|Person $composer
     * @return EventTrait
     */
    public function setComposer($composer)
    {
        $this->_composer = $composer;
        return $this;
    }

    /**
     * A secondary contributor to the CreativeWork or Event.
     *
     * @var Organization|Person
     */
    private $_contributor;

    /**
     * @return Organization|Person
     */
    public function getContributor()
    {
        return $this->_contributor;
    }

    /**
     * @param Organization|Person $contributor
     * @return EventTrait
     */
    public function setContributor($contributor)
    {
        $this->_contributor = $contributor;
        return $this;
    }

    /**
     * A director of e.g. tv, radio, movie, video gaming etc. content, or of an event.
     * Directors can be associated with individual items or with a series, episode, clip.
     * Supersedes directors.
     *
     * @var Person
     */
    private $_director;

    /**
     * @return Person
     */
    public function getDirector()
    {
        return $this->_director;
    }

    /**
     * @param Person $director
     * @return EventTrait
     */
    public function setDirector($director)
    {
        $this->_director = $director;
        return $this;
    }

    /**
     * The time admission will commence.
     *
     * @var DateTime
     */
    private $_doorTime;

    /**
     * @return DateTime
     */
    public function getDoorTime()
    {
        return $this->_doorTime;
    }

    /**
     * @param DateTime $doorTime
     * @return EventTrait
     */
    public function setDoorTime($doorTime)
    {
        $this->_doorTime = $doorTime;
        return $this;
    }

    /**
     * The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.
     *
     * @var Duration
     */
    private $_duration;

    /**
     * @return Duration
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * @param Duration $duration
     * @return EventTrait
     */
    public function setDuration($duration)
    {
        $this->_duration = $duration;
        return $this;
    }

    /**
     * The end date and time of the item (in ISO 8601 date format).
     *
     * @var Date|DateTime
     */
    private $_endDate;

    /**
     * @return Date|DateTime
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }

    /**
     * @param Date|DateTime $endDate
     * @return EventTrait
     */
    public function setEndDate($endDate)
    {
        $this->_endDate = $endDate;
        return $this;
    }

    /**
     * An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.
     *
     * @var EventStatusType
     */
    private $_eventStatus;

    /**
     * @return EventStatusType
     */
    public function getEventStatus()
    {
        return $this->_eventStatus;
    }

    /**
     * @param EventStatusType $eventStatus
     * @return EventTrait
     */
    public function setEventStatus($eventStatus)
    {
        $this->_eventStatus = $eventStatus;
        return $this;
    }

    /**
     * A person or organization that supports (sponsors) something through some kind of financial contribution.
     *
     * @var Organization|Person
     */
    private $_funder;

    /**
     * @return Organization|Person
     */
    public function getFunder()
    {
        return $this->_funder;
    }

    /**
     * @param Organization|Person $funder
     * @return EventTrait
     */
    public function setFunder($funder)
    {
        $this->_funder = $funder;
        return $this;
    }

    /**
     * The language of the content or performance or used in an action.
     * Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.
     * Supersedes language.
     *
     * @var Language|Text
     */
    private $_inLanguage;

    /**
     * @return Language|Text
     */
    public function getInLanguage()
    {
        return $this->_inLanguage;
    }

    /**
     * @param Language|Text $inLanguage
     * @return EventTrait
     */
    public function setInLanguage($inLanguage)
    {
        $this->_inLanguage = $inLanguage;
        return $this;
    }

    /**
     * A flag to signal that the item, event, or place is accessible for free. Supersedes free.
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
     * @return EventTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    /**
     * The location of for example where the event is happening, an organization is located,
     * or where an action takes place.
     *
     * @var Place|PostalAddress|string
     */
    private $_location;

    /**
     * @return Place|PostalAddress|string
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @param Place|PostalAddress|string $location
     * @return EventTrait
     */
    public function setLocation($location)
    {
        $this->_location = $location;
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
     */
    public function setMaximumAttendeeCapacity($maximumAttendeeCapacity)
    {
        $this->_maximumAttendeeCapacity = $maximumAttendeeCapacity;
    }

    /**
     * An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie,
     * perform a service, or give away tickets to an event.
     *
     * @var Offer
     */
    private $_offers;

    /**
     * @return Offer
     */
    public function getOffers()
    {
        return $this->_offers;
    }

    /**
     * @param Offer $offers
     * @return EventTrait
     */
    public function setOffers($offers)
    {
        $this->_offers = $offers;
        return $this;
    }

    /**
     * An organizer of an Event.
     *
     * @var Organization|Person
     */
    private $_organizer;

    /**
     * @return Organization|Person
     */
    public function getOrganizer()
    {
        return $this->_organizer;
    }

    /**
     * @param Organization|Person $organizer
     * @return EventTrait
     */
    public function setOrganizer($organizer)
    {
        $this->_organizer = $organizer;
        return $this;
    }

    /**
     * A performer at the event—for example, a presenter, musician, musical group or actor.
     * Supersedes performers.
     *
     * @var Organization|Person
     */
    private $_performer;

    /**
     * @return Organization|Person
     */
    public function getPerformer()
    {
        return $this->_performer;
    }

    /**
     * @param Organization|Person $performer
     * @return EventTrait
     */
    public function setPerformer($performer)
    {
        $this->_performer = $performer;
        return $this;
    }

    /**
     * Used in conjunction with eventStatus for rescheduled or cancelled events.
     * This property contains the previously scheduled start date.
     * For rescheduled events, the startDate property should be used for the newly scheduled start date.
     * In the (rare) case of an event that has been postponed and rescheduled multiple times,
     * this field may be repeated.
     *
     * @var Date
     */
    private $_previousStartDate;

    /**
     * @return Date
     */
    public function getPreviousStartDate()
    {
        return $this->_previousStartDate;
    }

    /**
     * @param Date $previousStartDate
     * @return EventTrait
     */
    public function setPreviousStartDate($previousStartDate)
    {
        $this->_previousStartDate = $previousStartDate;
        return $this;
    }

    /**
     * The CreativeWork that captured all or part of this Event.
     * Inverse property: recordedAt
     *
     * @var CreativeWork
     */
    private $_recordedIn;

    /**
     * @return CreativeWork
     */
    public function getRecordedIn()
    {
        return $this->_recordedIn;
    }

    /**
     * @param CreativeWork $recordedIn
     * @return EventTrait
     */
    public function setRecordedIn($recordedIn)
    {
        $this->_recordedIn = $recordedIn;
        return $this;
    }

    /**
     * The number of attendee places for an event that remain unallocated.
     *
     * @var Integer
     */
    private $_remainingAttendeeCapacity;

    /**
     * @return int
     */
    public function getRemainingAttendeeCapacity()
    {
        return $this->_remainingAttendeeCapacity;
    }

    /**
     * @param int $remainingAttendeeCapacity
     * @return EventTrait
     */
    public function setRemainingAttendeeCapacity($remainingAttendeeCapacity)
    {
        $this->_remainingAttendeeCapacity = $remainingAttendeeCapacity;
        return $this;
    }

    /**
     * A review of the item.
     * Supersedes reviews.
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
     * @return EventTrait
     */
    public function setReview($review)
    {
        $this->_review = $review;
        return $this;
    }

    /**
     * A person or organization that supports a thing through a pledge, promise, or financial contribution.
     * e.g. a sponsor of a Medical Study or a corporate sponsor of an event.
     *
     * @var Organization|Person
     */
    private $_sponsor;

    /**
     * @return Organization|Person
     */
    public function getSponsor()
    {
        return $this->_sponsor;
    }

    /**
     * @param Organization|Person $sponsor
     * @return EventTrait
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor = $sponsor;
        return $this;
    }

    /**
     * The start date and time of the item (in ISO 8601 date format).
     *
     * @var Date|DateTime
     */
    private $_startDate;

    /**
     * @return Date|DateTime
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * @param Date|DateTime $startDate
     * @return EventTrait
     */
    public function setStartDate($startDate)
    {
        $this->_startDate = $startDate;
        return $this;
    }

    /**
     * An Event that is part of this event.
     * For example, a conference event includes many presentations, each of which is a subEvent of the conference.
     * Supersedes subEvents.
     * Inverse property: superEvent.
     *
     * @var Event
     */
    private $_subEvent;

    /**
     * @return Event
     */
    public function getSubEvent()
    {
        return $this->_subEvent;
    }

    /**
     * @param Event $subEvent
     */
    public function setSubEvent($subEvent)
    {
        $this->_subEvent = $subEvent;
    }

    /**
     * An event that this event is a part of.
     * For example, a collection of individual music performances might each have a music festival as their superEvent.
     * Inverse property: subEvent.
     *
     * @var Event
     */
    private $_superEvent;

    /**
     * @return Event
     */
    public function getSuperEvent()
    {
        return $this->_superEvent;
    }

    /**
     * @param Event $superEvent
     * @return EventTrait
     */
    public function setSuperEvent($superEvent)
    {
        $this->_superEvent = $superEvent;
        return $this;
    }

    /**
     * Organization or person who adapts a creative work to different languages, regional differences
     * and technical requirements of a target market, or that translates during some event.
     *
     * @var Organization|Person
     */
    private $_translator;

    /**
     * @return Organization|Person
     */
    public function getTranslator()
    {
        return $this->_translator;
    }

    /**
     * @param Organization|Person $translator
     * @return EventTrait
     */
    public function setTranslator($translator)
    {
        $this->_translator = $translator;
        return $this;
    }

    /**
     * The typical expected age range, e.g. '7-9', '11-'.
     *
     * @var string
     */
    private $_typicalAgeRange;

    /**
     * @return string
     */
    public function getTypicalAgeRange()
    {
        return $this->_typicalAgeRange;
    }

    /**
     * @param string $typicalAgeRange
     * @return EventTrait
     */
    public function setTypicalAgeRange($typicalAgeRange)
    {
        $this->_typicalAgeRange = $typicalAgeRange;
        return $this;
    }

    /**
     * A work featured in some event, e.g. exhibited in an ExhibitionEvent.
     * Specific subproperties are available for workPerformed (e.g. a play),
     * or a workPresented (a Movie at a ScreeningEvent).
     *
     * @var CreativeWork
     */
    private $_workFeatured;

    /**
     * @return CreativeWork
     */
    public function getWorkFeatured()
    {
        return $this->_workFeatured;
    }

    /**
     * @param CreativeWork $workFeatured
     * @return EventTrait
     */
    public function setWorkFeatured($workFeatured)
    {
        $this->_workFeatured = $workFeatured;
        return $this;
    }

    /**
     * A work performed in some event, for example a play performed in a TheaterEvent.
     *
     * @var CreativeWork
     */
    private $_workPerformed;

    /**
     * @return CreativeWork
     */
    public function getWorkPerformed()
    {
        return $this->_workPerformed;
    }

    /**
     * @param CreativeWork $workPerformed
     * @return EventTrait
     */
    public function setWorkPerformed($workPerformed)
    {
        $this->_workPerformed = $workPerformed;
        return $this;
    }
}