<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Creative Work Trait
 *
 * @see http://schema.org/CreativeWork
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
trait CreativeWorkTrait
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAbout($about)
    {
        $this->_about = $about;
        return $this;
    }

    /**
     * The human sensory perceptual system or cognitive faculty through which a person may process or perceive
     * information.
     *
     * Expected values include: auditory, tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual,
     * diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.
     *
     * @var string
     */
    private $_accessMode;

    /**
     * @return string
     */
    public function getAccessMode()
    {
        return $this->_accessMode;
    }

    /**
     * @param string $accessMode
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessMode($accessMode)
    {
        $this->_accessMode = $accessMode;
        return $this;
    }

    /**
     * A list of single or combined accessModes that are sufficient to understand all the intellectual content of a
     * resource.
     *
     * Expected values include: auditory, tactile, textual, visual.
     *
     * @var string
     */
    private $_accessModeSufficient;

    /**
     * @return string
     */
    public function getAccessModeSufficient()
    {
        return $this->_accessModeSufficient;
    }

    /**
     * @param string $accessModeSufficient
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessModeSufficient($accessModeSufficient)
    {
        $this->_accessModeSufficient = $accessModeSufficient;
        return $this;
    }

    /**
     * Indicates that the resource is compatible with the referenced accessibility API
     * (WebSchemas wiki lists possible values).
     *
     * @var string
     */
    private $_accessibilityAPI;

    /**
     * @return string
     */
    public function getAccessibilityAPI()
    {
        return $this->_accessibilityAPI;
    }

    /**
     * @param string $accessibilityAPI
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityAPI($accessibilityAPI)
    {
        $this->_accessibilityAPI = $accessibilityAPI;
        return $this;
    }

    /**
     * Identifies input methods that are sufficient to fully control the described resource
     * (WebSchemas wiki lists possible values).
     *
     * @var string
     */
    private $_accessibilityControl;

    /**
     * @return string
     */
    public function getAccessibilityControl()
    {
        return $this->_accessibilityControl;
    }

    /**
     * @param string $accessibilityControl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityControl($accessibilityControl)
    {
        $this->_accessibilityControl = $accessibilityControl;
        return $this;
    }

    /**
     * Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility
     * (WebSchemas wiki lists possible values).
     *
     * @var string
     */
    private $_accessibilityFeature;

    /**
     * @return string
     */
    public function getAccessibilityFeature()
    {
        return $this->_accessibilityFeature;
    }

    /**
     * @param string $accessibilityFeature
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityFeature($accessibilityFeature)
    {
        $this->_accessibilityFeature = $accessibilityFeature;
        return $this;
    }

    /**
     * A characteristic of the described resource that is physiologically dangerous to some users.
     * Related to WCAG 2.0 guideline 2.3 (WebSchemas wiki lists possible values).
     *
     * @var string
     */
    private $_accessibilityHazard;

    /**
     * @return string
     */
    public function getAccessibilityHazard()
    {
        return $this->_accessibilityHazard;
    }

    /**
     * @param string $accessibilityHazard
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityHazard($accessibilityHazard)
    {
        $this->_accessibilityHazard = $accessibilityHazard;
        return $this;
    }

    /**
     * A human-readable summary of specific accessibility features or deficiencies, consistent with the other
     * accessibility metadata but expressing subtleties such as "short descriptions are present but long descriptions
     * will be needed for non-visual users" or "short descriptions are present and no long descriptions are needed."
     *
     * @var string
     */
    private $_accessibilitySummary;

    /**
     * @return string
     */
    public function getAccessibilitySummary()
    {
        return $this->_accessibilitySummary;
    }

    /**
     * @param string $accessibilitySummary
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilitySummary($accessibilitySummary)
    {
        $this->_accessibilitySummary = $accessibilitySummary;
        return $this;
    }

    /**
     * Specifies the Person that is legally accountable for the CreativeWork.
     *
     * @var Person
     */
    private $_accountablePerson;

    /**
     * @return Person
     */
    public function getAccountablePerson()
    {
        return $this->_accountablePerson;
    }

    /**
     * @param Person $accountablePerson
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccountablePerson($accountablePerson)
    {
        $this->_accountablePerson = $accountablePerson;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;
        return $this;
    }

    /**
     * A secondary title of the CreativeWork.
     *
     * @var string
     */
    private $_alternativeHeadline;

    /**
     * @return string
     */
    public function getAlternativeHeadline()
    {
        return $this->_alternativeHeadline;
    }

    /**
     * @param string $alternativeHeadline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAlternativeHeadline($alternativeHeadline)
    {
        $this->_alternativeHeadline = $alternativeHeadline;
        return $this;
    }

    /**
     * A media object that encodes this CreativeWork. This property is a synonym for encoding.
     *
     * @var MediaObject
     */
    private $_associatedMedia;

    /**
     * @return MediaObject
     */
    public function getAssociatedMedia()
    {
        return $this->_associatedMedia;
    }

    /**
     * @param MediaObject $associatedMedia
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAssociatedMedia($associatedMedia)
    {
        $this->_associatedMedia = $associatedMedia;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudience($audience)
    {
        $this->_audience = $audience;
        return $this;
    }

    /**
     * 	An embedded audio object.
     *
     * @var AudioObject
     */
    private $_audio;

    /**
     * @return AudioObject
     */
    public function getAudio()
    {
        return $this->_audio;
    }

    /**
     * @param AudioObject $audio
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudio($audio)
    {
        $this->_audio = $audio;
        return $this;
    }

    /**
     * The author of this content or rating. Please note that author is special in that HTML 5 provides a special
     * mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     *
     * @var Person|Organization
     */
    private $_author;

    /**
     * @return Organization|Person
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @param Organization|Person $author
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAuthor($author)
    {
        $this->_author = $author;
        return $this;
    }

    /**
     * An award won by or for this item.
     * Supersedes awards.
     *
     * @var string
     */
    private $_award;

    /**
     * @return string
     */
    public function getAward()
    {
        return $this->_award;
    }

    /**
     * @param string $award
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAward($award)
    {
        $this->_award = $award;
        return $this;
    }

    /**
     * Fictional person connected with a creative work.
     *
     * @var Person
     */
    private $_character;

    /**
     * @return Person
     */
    public function getCharacter()
    {
        return $this->_character;
    }

    /**
     * @param Person $character
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCharacter($character)
    {
        $this->_character = $character;
        return $this;
    }

    /**
     * A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.
     *
     * @var CreativeWork|string
     */
    private $_citation;

    /**
     * @return CreativeWork|string
     */
    public function getCitation()
    {
        return $this->_citation;
    }

    /**
     * @param CreativeWork|string $citation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCitation($citation)
    {
        $this->_citation = $citation;
        return $this;
    }

    /**
     * Comments, typically from users.
     *
     * @var Comment
     */
    private $_comment;

    /**
     * @return Comment
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @param Comment $comment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setComment($comment)
    {
        $this->_comment = $comment;
        return $this;
    }

    /**
     * The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most
     * applicable to works published in Web sites with commenting system; additional comments may exist elsewhere.
     *
     * @var int
     */
    private $_commentCount;

    /**
     * @return int
     */
    public function getCommentCount()
    {
        return $this->_commentCount;
    }

    /**
     * @param int $commentCount
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCommentCount($commentCount)
    {
        $this->_commentCount = $commentCount;
        return $this;
    }

    /**
     * The location depicted or described in the content. For example, the location in a photograph or painting.
     *
     * @var Place
     */
    private $_contentLocation;

    /**
     * @return Place
     */
    public function getContentLocation()
    {
        return $this->_contentLocation;
    }

    /**
     * @param Place $contentLocation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentLocation($contentLocation)
    {
        $this->_contentLocation = $contentLocation;
        return $this;
    }

    /**
     * Official rating of a piece of content—for example,'MPAA PG-13'.
     *
     * @var string
     */
    private $_contentRating;

    /**
     * @return string
     */
    public function getContentRating()
    {
        return $this->_contentRating;
    }

    /**
     * @param string $contentRating
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentRating($contentRating)
    {
        $this->_contentRating = $contentRating;
        return $this;
    }

    /**
     * The specific time described by a creative work, for works (e.g. articles, video objects etc.) that emphasise
     * a particular moment within an Event.
     *
     * @var DateTime
     */
    private $_contentReferenceTime;

    /**
     * @return DateTime
     */
    public function getContentReferenceTime()
    {
        return $this->_contentReferenceTime;
    }

    /**
     * @param DateTime $contentReferenceTime
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentReferenceTime($contentReferenceTime)
    {
        $this->_contentReferenceTime = $contentReferenceTime;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContributor($contributor)
    {
        $this->_contributor = $contributor;
        return $this;
    }

    /**
     * The party holding the legal copyright to the CreativeWork.
     *
     * @var Organization|Person
     */
    private $_copyrightHolder;

    /**
     * @return Organization|Person
     */
    public function getCopyrightHolder()
    {
        return $this->_copyrightHolder;
    }

    /**
     * @param Organization|Person $copyrightHolder
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightHolder($copyrightHolder)
    {
        $this->_copyrightHolder = $copyrightHolder;
        return $this;
    }

    /**
     * The year during which the claimed copyright for the CreativeWork was first asserted.
     *
     * @var int
     */
    private $_copyrightYear;

    /**
     * @return mixed
     */
    public function getCopyrightYear()
    {
        return $this->_copyrightYear;
    }

    /**
     * @param mixed $copyrightYear
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightYear($copyrightYear)
    {
        $this->_copyrightYear = $copyrightYear;
        return $this;
    }

    /**
     * The creator/author of this CreativeWork. This is the same as the Author property for CreativeWork.
     *
     * @var Organization|Person
     */
    private $_creator;

    /**
     * @return Organization|Person
     */
    public function getCreator()
    {
        return $this->_creator;
    }

    /**
     * @param Organization|Person $creator
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCreator($creator)
    {
        $this->_creator = $creator;
        return $this;
    }

    /**
     * The date on which the CreativeWork was created or the item was added to a DataFeed.
     *
     * @var Date|DateTime
     */
    private $_dateCreated;

    /**
     * @return Date|DateTime
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * @param Date|DateTime $dateCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateCreated($dateCreated)
    {
        $this->_dateCreated = $dateCreated;
        return $this;
    }

    /**
     * The date on which the CreativeWork was most recently modified
     * or when the item's entry was modified within a DataFeed.
     *
     * @var Date|DateTime
     */
    private $_dateModified;

    /**
     * @return Date|DateTime
     */
    public function getDateModified()
    {
        return $this->_dateModified;
    }

    /**
     * @param Date|DateTime $dateModified
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateModified($dateModified)
    {
        $this->_dateModified = $dateModified;
        return $this;
    }

    /**
     * Date of first broadcast/publication.
     *
     * @var Date
     */
    private $_datePublished;

    /**
     * @return Date
     */
    public function getDatePublished()
    {
        return $this->_datePublished;
    }

    /**
     * @param Date $datePublished
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDatePublished($datePublished)
    {
        $this->_datePublished = $datePublished;
        return $this;
    }

    /**
     * A link to the page containing the comments of the CreativeWork.
     *
     * @var URL
     */
    private $_discussionUrl;

    /**
     * @return URL
     */
    public function getDiscussionUrl()
    {
        return $this->_discussionUrl;
    }

    /**
     * @param URL $discussionUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDiscussionUrl($discussionUrl)
    {
        $this->_discussionUrl = $discussionUrl;
        return $this;
    }

    /**
     * Specifies the Person who edited the CreativeWork.
     *
     * @var Person
     */
    private $_editor;

    /**
     * @return Person
     */
    public function getEditor()
    {
        return $this->_editor;
    }

    /**
     * @param Person $editor
     */
    public function setEditor($editor)
    {
        $this->_editor = $editor;
    }

    /**
     * An alignment to an established educational framework.
     *
     * @var AlignmentObject
     */
    private $_educationalAlignment;

    /**
     * @return AlignmentObject
     */
    public function getEducationalAlignment()
    {
        return $this->_educationalAlignment;
    }

    /**
     * @param AlignmentObject $educationalAlignment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalAlignment($educationalAlignment)
    {
        $this->_educationalAlignment = $educationalAlignment;
        return $this;
    }

    /**
     * The purpose of a work in the context of education; for example, 'assignment', 'group work'.
     *
     * @var string
     */
    private $_educationalUse;

    /**
     * @return string
     */
    public function getEducationalUse()
    {
        return $this->_educationalUse;
    }

    /**
     * @param string $educationalUse
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalUse($educationalUse)
    {
        $this->_educationalUse = $educationalUse;
        return $this;
    }

    /**
     * A media object that encodes this CreativeWork. This property is a synonym for associatedMedia.
     * Supersedes encodings.
     *
     * @var MediaObject
     */
    private $_encoding;

    /**
     * @return MediaObject
     */
    public function getEncoding()
    {
        return $this->_encoding;
    }

    /**
     * @param MediaObject $encoding
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEncoding($encoding)
    {
        $this->_encoding = $encoding;
        return $this;
    }

    /**
     * A creative work that this work is an example/instance/realization/derivation of.
     * Inverse property: workExample.
     *
     * @var CreativeWork
     */
    private $_exampleOfWork;

    /**
     * @return CreativeWork
     */
    public function getExampleOfWork()
    {
        return $this->_exampleOfWork;
    }

    /**
     * @param CreativeWork $exampleOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExampleOfWork($exampleOfWork)
    {
        $this->_exampleOfWork = $exampleOfWork;
        return $this;
    }

    /**
     * Date the content expires and is no longer useful or available. For example a VideoObject or NewsArticle whose
     * availability or relevance is time-limited, or a ClaimReview fact check whose publisher wants to indicate that
     * it may no longer be relevant (or helpful to highlight) after some date.
     *
     * @var Date
     */
    private $_expires;

    /**
     * @return Date
     */
    public function getExpires()
    {
        return $this->_expires;
    }

    /**
     * @param Date $expires
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExpires($expires)
    {
        $this->_expires = $expires;
        return $this;
    }

    /**
     * Media type, typically MIME format (see IANA site) of the content e.g. application/zip of a SoftwareApplication
     * binary. In cases where a CreativeWork has several media type representations, 'encoding' can be used to indicate
     * each MediaObject alongside particular fileFormat information. Unregistered or niche file formats can be indicated
     * instead via the most appropriate URL, e.g. defining Web page or a Wikipedia entry.
     *
     * @var string|URL
     */
    private $_fileFormat;

    /**
     * @return URL|string
     */
    public function getFileFormat()
    {
        return $this->_fileFormat;
    }

    /**
     * @param URL|string $fileFormat
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFileFormat($fileFormat)
    {
        $this->_fileFormat = $fileFormat;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFunder($funder)
    {
        $this->_funder = $funder;
        return $this;
    }

    /**
     * Genre of the creative work, broadcast channel or group.
     *
     * @var URL|string
     */
    private $_genre;

    /**
     * @return URL|string
     */
    public function getGenre()
    {
        return $this->_genre;
    }

    /**
     * @param URL|string $genre
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setGenre($genre)
    {
        $this->_genre = $genre;
        return $this;
    }

    /**
     * Indicates a CreativeWork that is (in some sense) a part of this CreativeWork.
     * Inverse property: isPartOf.
     *
     * @var CreativeWork
     */
    private $_hasPart;

    /**
     * @return CreativeWork
     */
    public function getHasPart()
    {
        return $this->_hasPart;
    }

    /**
     * @param CreativeWork $hasPart
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHasPart($hasPart)
    {
        $this->_hasPart = $hasPart;
        return $this;
    }

    /**
     * Headline of the article.
     *
     * @var string
     */
    private $_headline;

    /**
     * @return string
     */
    public function getHeadline()
    {
        return $this->_headline;
    }

    /**
     * @param string $headline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHeadline($headline)
    {
        $this->_headline = $headline;
        return $this;
    }

    /**
     * The language of the content or performance or used in an action.
     * Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.
     * Supersedes language.
     *
     * @var Language|string
     */
    private $_inLanguage;

    /**
     * @return Language|string
     */
    public function getInLanguage()
    {
        return $this->_inLanguage;
    }

    /**
     * @param Language|string $inLanguage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInLanguage($inLanguage)
    {
        $this->_inLanguage = $inLanguage;
        return $this;
    }

    /**
     * The number of interactions for the CreativeWork using the WebSite or SoftwareApplication.
     * The most specific child type of InteractionCounter should be used.
     *
     * Supersedes interactionCount.
     *
     * @var InteractionCounter
     */
    private $_interactionStatistic;

    /**
     * @return InteractionCounter
     */
    public function getInteractionStatistic()
    {
        return $this->_interactionStatistic;
    }

    /**
     * @param InteractionCounter $interactionStatistic
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractionStatistic($interactionStatistic)
    {
        $this->_interactionStatistic = $interactionStatistic;
        return $this;
    }

    /**
     * The predominant mode of learning supported by the learning resource.
     * Acceptable values are 'active', 'expositive', or 'mixed'.
     *
     * @var string
     */
    private $_interactivityType;

    /**
     * @return string
     */
    public function getInteractivityType()
    {
        return $this->_interactivityType;
    }

    /**
     * @param string $interactivityType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractivityType($interactivityType)
    {
        $this->_interactivityType = $interactivityType;
        return $this;
    }

    /**
     * A flag to signal that the item, event, or place is accessible for free.
     * Supersedes free.
     *
     * @var boolean
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    /**
     * A resource that was used in the creation of this resource. This term can be repeated for multiple sources.
     * For example, http://example.com/great-multiplication-intro.html.
     * Supersedes isBasedOnUrl.
     *
     * @var CreativeWork|Product|Url
     */
    private $_isBasedOn;

    /**
     * @return CreativeWork|Product|Url
     */
    public function getisBasedOn()
    {
        return $this->_isBasedOn;
    }

    /**
     * @param CreativeWork|Product|Url $isBasedOn
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsBasedOn($isBasedOn)
    {
        $this->_isBasedOn = $isBasedOn;
        return $this;
    }

    /**
     * Indicates whether this content is family friendly.
     *
     * @var boolean
     */
    private $_isFamilyFriendly;

    /**
     * @return bool
     */
    public function isFamilyFriendly()
    {
        return $this->_isFamilyFriendly;
    }

    /**
     * @param bool $isFamilyFriendly
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsFamilyFriendly($isFamilyFriendly)
    {
        $this->_isFamilyFriendly = $isFamilyFriendly;
        return $this;
    }

    /**
     * Indicates a CreativeWork that this CreativeWork is (in some sense) part of.
     * Inverse property: hasPart.
     *
     * @var CreativeWork
     */
    private $_isPartOf;

    /**
     * @return CreativeWork
     */
    public function getisPartOf()
    {
        return $this->_isPartOf;
    }

    /**
     * @param CreativeWork $isPartOf
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsPartOf($isPartOf)
    {
        $this->_isPartOf = $isPartOf;
        return $this;
    }

    /**
     * Keywords or tags used to describe this content.
     * Multiple entries in a keywords list are typically delimited by commas.
     *
     * @var string
     */
    private $_keywords;

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    /**
     * @param string $keywords
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
        return $this;
    }

    /**
     * The predominant type or kind characterizing the learning resource. For example, 'presentation', 'handout'.
     *
     * @var string
     */
    private $_learningResourceType;

    /**
     * @return string
     */
    public function getLearningResourceType()
    {
        return $this->_learningResourceType;
    }

    /**
     * @param string $learningResourceType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLearningResourceType($learningResourceType)
    {
        $this->_learningResourceType = $learningResourceType;
        return $this;
    }

    /**
     * A license document that applies to this content, typically indicated by URL.
     *
     * @var CreativeWork|URL
     */
    private $_license;

    /**
     * @return CreativeWork|URL
     */
    public function getLicense()
    {
        return $this->_license;
    }

    /**
     * @param CreativeWork|URL $license
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLicense($license)
    {
        $this->_license = $license;
        return $this;
    }

    /**
     * The location where the CreativeWork was created, which may not be the same as the location depicted in the CreativeWork.
     *
     * @var Place
     */
    private $_locationCreated;

    /**
     * @return Place
     */
    public function getLocationCreated()
    {
        return $this->_locationCreated;
    }

    /**
     * @param Place $locationCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLocationCreated($locationCreated)
    {
        $this->_locationCreated = $locationCreated;
        return $this;
    }

    /**
     * Indicates the primary entity described in some page or other CreativeWork.
     * Inverse property: mainEntityOfPage.
     *
     * @var Thing
     */
    private $_mainEntity;

    /**
     * @return Thing
     */
    public function getMainEntity()
    {
        return $this->_mainEntity;
    }

    /**
     * @param Thing $mainEntity
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMainEntity($mainEntity)
    {
        $this->_mainEntity = $mainEntity;
        return $this;
    }

    /**
     * A material that something is made from, e.g. leather, wool, cotton, paper.
     *
     * @var Product|URL|string
     */
    private $_material;

    /**
     * @return Product|URL|string
     */
    public function getMaterial()
    {
        return $this->_material;
    }

    /**
     * @param Product|URL|string $material
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMaterial($material)
    {
        $this->_material = $material;
        return $this;
    }

    /**
     * Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.
     *
     * @var Thing
     */
    private $_mentions;

    /**
     * @return Thing
     */
    public function getMentions()
    {
        return $this->_mentions;
    }

    /**
     * @param Thing $mentions
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMentions($mentions)
    {
        $this->_mentions = $mentions;
        return $this;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setOffers($offers)
    {
        $this->_offers = $offers;
        return $this;
    }

    /**
     * The position of an item in a series or sequence of items.
     *
     * @var int|string
     */
    private $_position;

    /**
     * @return int|string
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * @param int|string $position
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPosition($position)
    {
        $this->_position = $position;
        return $this;
    }

    /**
     * The person or organization who produced the work (e.g. music album, movie, tv/radio series etc.).
     *
     * @var Organization|Person
     */
    private $_producer;

    /**
     * @return Organization|Person
     */
    public function getProducer()
    {
        return $this->_producer;
    }

    /**
     * @param Organization|Person $producer
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProducer($producer)
    {
        $this->_producer = $producer;
        return $this;
    }

    /**
     * The service provider, service operator, or service performer; the goods producer. Another party (a seller)
     * may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * Supersedes carrier.
     *
     * @var Organization|Person
     */
    private $_provider;

    /**
     * @return Organization|Person
     */
    public function getProvider()
    {
        return $this->_provider;
    }

    /**
     * @param Organization|Person $provider
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProvider($provider)
    {
        $this->_provider = $provider;
        return $this;
    }

    /**
     * A publication event associated with the item.
     *
     * @var PublicationEvent
     */
    private $_publication;

    /**
     * @return PublicationEvent
     */
    public function getPublication()
    {
        return $this->_publication;
    }

    /**
     * @param PublicationEvent $publication
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublication($publication)
    {
        $this->_publication = $publication;
        return $this;
    }

    /**
     * The publisher of the creative work.
     *
     * @var Organization|Person
     */
    private $_publisher;

    /**
     * @return Organization|Person
     */
    public function getPublisher()
    {
        return $this->_publisher;
    }

    /**
     * @param Organization|Person $publisher
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisher($publisher)
    {
        $this->_publisher = $publisher;
        return $this;
    }

    /**
     * The publishing division which published the comic.
     *
     * @var Organization
     */
    private $_publisherImprint;

    /**
     * @return Organization
     */
    public function getPublisherImprint()
    {
        return $this->_publisherImprint;
    }

    /**
     * @param Organization $publisherImprint
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisherImprint($publisherImprint)
    {
        $this->_publisherImprint = $publisherImprint;
        return $this;
    }

    /**
     * The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles
     * of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher,
     * e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those
     * of the party primarily responsible for the creation of the CreativeWork.
     *
     * While such policies are most typically expressed in natural language, sometimes related information
     * (e.g. indicating a funder) can be expressed using schema.org terminology.
     *
     * @var CreativeWork|URL
     */
    private $_publishingPrinciples;

    /**
     * @return CreativeWork|URL
     */
    public function getPublishingPrinciples()
    {
        return $this->_publishingPrinciples;
    }

    /**
     * @param CreativeWork|URL $publishingPrinciples
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublishingPrinciples($publishingPrinciples)
    {
        $this->_publishingPrinciples = $publishingPrinciples;
        return $this;
    }

    /**
     * The Event where the CreativeWork was recorded. The CreativeWork may capture all or part of the event.
     * Inverse property: recordedIn.
     *
     * @var Event
     */
    private $_recordedAt;

    /**
     * @return Event
     */
    public function getRecordedAt()
    {
        return $this->_recordedAt;
    }

    /**
     * @param Event $recordedAt
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setRecordedAt($recordedAt)
    {
        $this->_recordedAt = $recordedAt;
        return $this;
    }

    /**
     * The place and time the release was issued, expressed as a PublicationEvent.
     *
     * @var PublicationEvent
     */
    private $_releasedEvent;

    /**
     * @return PublicationEvent
     */
    public function getReleasedEvent()
    {
        return $this->_releasedEvent;
    }

    /**
     * @param PublicationEvent $releasedEvent
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReleasedEvent($releasedEvent)
    {
        $this->_releasedEvent = $releasedEvent;
        return $this;
    }

    /**
     * 	A review of the item. Supersedes reviews.
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReview($review)
    {
        $this->_review = $review;
        return $this;
    }

    /**
     * Indicates (by URL or string) a particular version of a schema used in some CreativeWork.
     * For example, a document could declare a schemaVersion using an URL such as http://schema.org/version/2.0/
     * if precise indication of schema version was required by some application.
     *
     * @var URL|string
     */
    private $_schemaVersion;

    /**
     * @return URL|string
     */
    public function getSchemaVersion()
    {
        return $this->_schemaVersion;
    }

    /**
     * @param URL|string $schemaVersion
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSchemaVersion($schemaVersion)
    {
        $this->_schemaVersion = $schemaVersion;
        return $this;
    }

    /**
     * The Organization on whose behalf the creator was working.
     *
     * @var Organization
     */
    private $_sourceOrganization;

    /**
     * @return Organization
     */
    public function getSourceOrganization()
    {
        return $this->_sourceOrganization;
    }

    /**
     * @param Organization $sourceOrganization
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSourceOrganization($sourceOrganization)
    {
        $this->_sourceOrganization = $sourceOrganization;
        return $this;
    }

    /**
     * The spatialCoverage of a CreativeWork indicates the place(s) which are the focus of the content.
     * It is a subproperty of contentLocation intended primarily for more technical and detailed materials.
     * For example with a Dataset, it indicates areas that the dataset describes: a dataset of New York weather would
     * have spatialCoverage which was the place: the state of New York. Supersedes spatial.
     *
     * @var Place
     */
    private $_spatialCoverage;

    /**
     * @return Place
     */
    public function getSpatialCoverage()
    {
        return $this->_spatialCoverage;
    }

    /**
     * @param Place $spatialCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSpatialCoverage($spatialCoverage)
    {
        $this->_spatialCoverage = $spatialCoverage;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor = $sponsor;
        return $this;
    }

    /**
     * The temporalCoverage of a CreativeWork indicates the period that the content applies to,
     * i.e. that it describes, either as a DateTime or as a textual string indicating a time period in ISO 8601 time
     * interval format. In the case of a Dataset it will typically indicate the relevant time period in a precise
     * notation (e.g. for a 2011 census dataset, the year 2011 would be written "2011/2012"). Other forms of content
     * e.g. ScholarlyArticle, Book, TVSeries or TVEpisode may indicate their temporalCoverage in broader terms -
     * textually or via well-known URL. Written works such as books may sometimes have precise temporal coverage too,
     * e.g. a work set in 1939 - 1945 can be indicated in ISO 8601 interval format format via "1939/1945".
     * Supersedes datasetTimeInterval, temporal.
     *
     * @var DateTime|URL|string
     */
    private $_temporalCoverage;

    /**
     * @return DateTime|URL|string
     */
    public function getTemporalCoverage()
    {
        return $this->_temporalCoverage;
    }

    /**
     * @param DateTime|URL|string $temporalCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTemporalCoverage($temporalCoverage)
    {
        $this->_temporalCoverage = $temporalCoverage;
        return $this;
    }

    /**
     * The textual content of this CreativeWork.
     *
     * @var string
     */
    private $_text;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @param string $text
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    /**
     * 	A thumbnail image relevant to the Thing.
     *
     * @var URL
     */
    private $_thumbnailUrl;

    /**
     * @return URL
     */
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }

    /**
     * @param URL $thumbnailUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->_thumbnailUrl = $thumbnailUrl;
        return $this;
    }

    /**
     * Approximate or typical time it takes to work with or through this learning resource for the typical intended
     * target audience, e.g. 'P30M', 'P1H25M'.
     *
     * @var Duration
     */
    private $_timeRequired;

    /**
     * @return Duration
     */
    public function getTimeRequired()
    {
        return $this->_timeRequired;
    }

    /**
     * @param Duration $timeRequired
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTimeRequired($timeRequired)
    {
        $this->_timeRequired = $timeRequired;
        return $this;
    }

    /**
     * The work that this work has been translated from. e.g. 物种起源 is a translationOf “On the Origin of Species”
     * Inverse property: workTranslation.
     *
     * @var CreativeWork
     */
    private $_translationOfWork;

    /**
     * @return CreativeWork
     */
    public function getTranslationOfWork()
    {
        return $this->_translationOfWork;
    }

    /**
     * @param CreativeWork $translationOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTranslationOfWork($translationOfWork)
    {
        $this->_translationOfWork = $translationOfWork;
        return $this;
    }

    /**
     * Organization or person who adapts a creative work to different languages, regional differences and technical
     * requirements of a target market, or that translates during some event.
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
     * @return CreativeWork|CreativeWorkTrait
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTypicalAgeRange($typicalAgeRange)
    {
        $this->_typicalAgeRange = $typicalAgeRange;
        return $this;
    }

    /**
     * The version of the CreativeWork embodied by a specified resource.
     *
     * @var int|string
     */
    private $_version;

    /**
     * @return int|string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * @param int|string $version
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    /**
     * 	An embedded video object.
     *
     * @var VideoObject
     */
    private $_video;

    /**
     * @return VideoObject
     */
    public function getVideo()
    {
        return $this->_video;
    }

    /**
     * @param VideoObject $video
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVideo($video)
    {
        $this->_video = $video;
        return $this;
    }

    /**
     * Example/instance/realization/derivation of the concept of this creative work.
     * eg. The paperback edition, first edition, or eBook.
     * Inverse property: exampleOfWork.
     *
     * @var CreativeWork
     */
    private $_workExample;

    /**
     * @return CreativeWork
     */
    public function getWorkExample()
    {
        return $this->_workExample;
    }

    /**
     * @param CreativeWork $workExample
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkExample($workExample)
    {
        $this->_workExample = $workExample;
        return $this;
    }

    /**
     * A work that is a translation of the content of this work. e.g. 西遊記 has an English workTranslation “Journey to
     * the West”,a German workTranslation “Monkeys Pilgerfahrt” and a Vietnamese translation Tây du ký bình khảo.
     * Inverse property: translationOfWork.
     *
     * @var CreativeWork
     */
    private $_workTranslation;

    /**
     * @return CreativeWork
     */
    public function getWorkTranslation()
    {
        return $this->_workTranslation;
    }

    /**
     * @param CreativeWork $workTranslation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkTranslation($workTranslation)
    {
        $this->_workTranslation = $workTranslation;
        return $this;
    }

}