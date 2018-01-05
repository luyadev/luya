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
    use ThingTrait;

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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAbout($about)
    {
        $this->_about = $about;
        return $this;
    }

    private $_accessMode;

    /**
     * @return string
     */
    public function getAccessMode()
    {
        return $this->_accessMode;
    }

    /**
     * The human sensory perceptual system or cognitive faculty through which a person may process or perceive
     * information.
     *
     * Expected values include: auditory, tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual,
     * diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.
     *
     * @param string $accessMode
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessMode($accessMode)
    {
        $this->_accessMode = $accessMode;
        return $this;
    }

    private $_accessModeSufficient;

    /**
     * @return string
     */
    public function getAccessModeSufficient()
    {
        return $this->_accessModeSufficient;
    }

    /**
     * A list of single or combined accessModes that are sufficient to understand all the intellectual content of a
     * resource.
     *
     * Expected values include: auditory, tactile, textual, visual.
     *
     * @param string $accessModeSufficient
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessModeSufficient($accessModeSufficient)
    {
        $this->_accessModeSufficient = $accessModeSufficient;
        return $this;
    }

    private $_accessibilityAPI;

    /**
     * @return string
     */
    public function getAccessibilityAPI()
    {
        return $this->_accessibilityAPI;
    }

    /**
     * Indicates that the resource is compatible with the referenced accessibility API
     * (WebSchemas wiki lists possible values).
     *
     * @param string $accessibilityAPI
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityAPI($accessibilityAPI)
    {
        $this->_accessibilityAPI = $accessibilityAPI;
        return $this;
    }

    private $_accessibilityControl;

    /**
     * @return string
     */
    public function getAccessibilityControl()
    {
        return $this->_accessibilityControl;
    }

    /**
     * Identifies input methods that are sufficient to fully control the described resource
     * (WebSchemas wiki lists possible values).
     *
     * @param string $accessibilityControl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityControl($accessibilityControl)
    {
        $this->_accessibilityControl = $accessibilityControl;
        return $this;
    }

    private $_accessibilityFeature;

    /**
     * @return string
     */
    public function getAccessibilityFeature()
    {
        return $this->_accessibilityFeature;
    }

    /**
     * Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility
     * (WebSchemas wiki lists possible values).
     *
     * @param string $accessibilityFeature
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityFeature($accessibilityFeature)
    {
        $this->_accessibilityFeature = $accessibilityFeature;
        return $this;
    }

    private $_accessibilityHazard;

    /**
     * @return string
     */
    public function getAccessibilityHazard()
    {
        return $this->_accessibilityHazard;
    }

    /**
     * A characteristic of the described resource that is physiologically dangerous to some users.
     * Related to WCAG 2.0 guideline 2.3 (WebSchemas wiki lists possible values).
     *
     * @param string $accessibilityHazard
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityHazard($accessibilityHazard)
    {
        $this->_accessibilityHazard = $accessibilityHazard;
        return $this;
    }

    private $_accessibilitySummary;

    /**
     * @return string
     */
    public function getAccessibilitySummary()
    {
        return $this->_accessibilitySummary;
    }

    /**
     * A human-readable summary of specific accessibility features or deficiencies, consistent with the other
     * accessibility metadata but expressing subtleties such as "short descriptions are present but long descriptions
     * will be needed for non-visual users" or "short descriptions are present and no long descriptions are needed."
     *
     * @param string $accessibilitySummary
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilitySummary($accessibilitySummary)
    {
        $this->_accessibilitySummary = $accessibilitySummary;
        return $this;
    }

    private $_accountablePerson;

    /**
     * @return Person
     */
    public function getAccountablePerson()
    {
        return $this->_accountablePerson;
    }

    /**
     * Specifies the Person that is legally accountable for the CreativeWork.
     *
     * @param Person $accountablePerson
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccountablePerson($accountablePerson)
    {
        $this->_accountablePerson = $accountablePerson;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating = $aggregateRating;
        return $this;
    }

    private $_alternativeHeadline;

    /**
     * @return string
     */
    public function getAlternativeHeadline()
    {
        return $this->_alternativeHeadline;
    }

    /**
     * A secondary title of the CreativeWork.
     *
     * @param string $alternativeHeadline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAlternativeHeadline($alternativeHeadline)
    {
        $this->_alternativeHeadline = $alternativeHeadline;
        return $this;
    }

    private $_associatedMedia;

    /**
     * @return MediaObject
     */
    public function getAssociatedMedia()
    {
        return $this->_associatedMedia;
    }

    /**
     * A media object that encodes this CreativeWork. This property is a synonym for encoding.
     *
     * @param MediaObject $associatedMedia
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAssociatedMedia($associatedMedia)
    {
        $this->_associatedMedia = $associatedMedia;
        return $this;
    }

    private $_audience;

    /**
     * @return Audience
     */
    public function getAudience()
    {
        return $this->_audience;
    }

    /**
     * An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.
     *
     * @param Audience $audience
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudience($audience)
    {
        $this->_audience = $audience;
        return $this;
    }

    private $_audio;

    /**
     * @return AudioObject
     */
    public function getAudio()
    {
        return $this->_audio;
    }

    /**
     * 	An embedded audio object.
     *
     * @param AudioObject $audio
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudio($audio)
    {
        $this->_audio = $audio;
        return $this;
    }

    private $_author;

    /**
     * @return Organization|Person
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * The author of this content or rating. Please note that author is special in that HTML 5 provides a special
     * mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     *
     * @param Organization|Person $author
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAuthor($author)
    {
        $this->_author = $author;
        return $this;
    }

    private $_award;

    /**
     * @return string
     */
    public function getAward()
    {
        return $this->_award;
    }

    /**
     * An award won by or for this item.
     * Supersedes awards.
     *
     * @param string $award
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAward($award)
    {
        $this->_award = $award;
        return $this;
    }

    private $_character;

    /**
     * @return Person
     */
    public function getCharacter()
    {
        return $this->_character;
    }

    /**
     * Fictional person connected with a creative work.
     *
     * @param Person $character
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCharacter($character)
    {
        $this->_character = $character;
        return $this;
    }

    private $_citation;

    /**
     * @return CreativeWork|string
     */
    public function getCitation()
    {
        return $this->_citation;
    }

    /**
     * A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.
     *
     * @param CreativeWork|string $citation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCitation($citation)
    {
        $this->_citation = $citation;
        return $this;
    }

    private $_comment;

    /**
     * @return Comment
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * Comments, typically from users.
     *
     * @param Comment $comment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setComment($comment)
    {
        $this->_comment = $comment;
        return $this;
    }

    private $_commentCount;

    /**
     * @return int
     */
    public function getCommentCount()
    {
        return $this->_commentCount;
    }

    /**
     * The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most
     * applicable to works published in Web sites with commenting system; additional comments may exist elsewhere.
     *
     * @param int $commentCount
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCommentCount($commentCount)
    {
        $this->_commentCount = $commentCount;
        return $this;
    }

    private $_contentLocation;

    /**
     * @return Place
     */
    public function getContentLocation()
    {
        return $this->_contentLocation;
    }

    /**
     * The location depicted or described in the content. For example, the location in a photograph or painting.
     *
     * @param Place $contentLocation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentLocation($contentLocation)
    {
        $this->_contentLocation = $contentLocation;
        return $this;
    }

    private $_contentRating;

    /**
     * @return string
     */
    public function getContentRating()
    {
        return $this->_contentRating;
    }

    /**
     * Official rating of a piece of content—for example,'MPAA PG-13'.
     *
     * @param string $contentRating
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentRating($contentRating)
    {
        $this->_contentRating = $contentRating;
        return $this;
    }

    private $_contentReferenceTime;

    /**
     * @return DateTime
     */
    public function getContentReferenceTime()
    {
        return $this->_contentReferenceTime;
    }

    /**
     * The specific time described by a creative work, for works (e.g. articles, video objects etc.) that emphasise
     * a particular moment within an Event.
     *
     * @param DateTime $contentReferenceTime
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentReferenceTime($contentReferenceTime)
    {
        $this->_contentReferenceTime = $contentReferenceTime;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContributor($contributor)
    {
        $this->_contributor = $contributor;
        return $this;
    }

    private $_copyrightHolder;

    /**
     * @return Organization|Person
     */
    public function getCopyrightHolder()
    {
        return $this->_copyrightHolder;
    }

    /**
     * The party holding the legal copyright to the CreativeWork.
     *
     * @param Organization|Person $copyrightHolder
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightHolder($copyrightHolder)
    {
        $this->_copyrightHolder = $copyrightHolder;
        return $this;
    }

    private $_copyrightYear;

    /**
     * @return mixed
     */
    public function getCopyrightYear()
    {
        return $this->_copyrightYear;
    }

    /**
     * The year during which the claimed copyright for the CreativeWork was first asserted.
     *
     * @param mixed $copyrightYear
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightYear($copyrightYear)
    {
        $this->_copyrightYear = $copyrightYear;
        return $this;
    }

    private $_creator;

    /**
     * @return Organization|Person
     */
    public function getCreator()
    {
        return $this->_creator;
    }

    /**
     * The creator/author of this CreativeWork. This is the same as the Author property for CreativeWork.
     *
     * @param Organization|Person $creator
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCreator($creator)
    {
        $this->_creator = $creator;
        return $this;
    }

    private $_dateCreated;

    /**
     * @return Date|DateTime
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * The date on which the CreativeWork was created or the item was added to a DataFeed.
     *
     * @param Date|DateTime $dateCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateCreated($dateCreated)
    {
        $this->_dateCreated = $dateCreated;
        return $this;
    }

    private $_dateModified;

    /**
     * @return Date|DateTime
     */
    public function getDateModified()
    {
        return $this->_dateModified;
    }

    /**
     * The date on which the CreativeWork was most recently modified
     * or when the item's entry was modified within a DataFeed.
     *
     * @param Date|DateTime $dateModified
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateModified($dateModified)
    {
        $this->_dateModified = $dateModified;
        return $this;
    }

    private $_datePublished;

    /**
     * @return Date
     */
    public function getDatePublished()
    {
        return $this->_datePublished;
    }

    /**
     * Date of first broadcast/publication.
     *
     * @param Date $datePublished
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDatePublished($datePublished)
    {
        $this->_datePublished = $datePublished;
        return $this;
    }

    private $_discussionUrl;

    /**
     * @return URL
     */
    public function getDiscussionUrl()
    {
        return $this->_discussionUrl;
    }

    /**
     * A link to the page containing the comments of the CreativeWork.
     *
     * @param URL $discussionUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDiscussionUrl($discussionUrl)
    {
        $this->_discussionUrl = $discussionUrl;
        return $this;
    }

    private $_editor;

    /**
     * @return Person
     */
    public function getEditor()
    {
        return $this->_editor;
    }

    /**
     * Specifies the Person who edited the CreativeWork.
     *
     * @param Person $editor
     */
    public function setEditor($editor)
    {
        $this->_editor = $editor;
    }

    private $_educationalAlignment;

    /**
     * @return AlignmentObject
     */
    public function getEducationalAlignment()
    {
        return $this->_educationalAlignment;
    }

    /**
     * An alignment to an established educational framework.
     *
     * @param AlignmentObject $educationalAlignment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalAlignment($educationalAlignment)
    {
        $this->_educationalAlignment = $educationalAlignment;
        return $this;
    }

    private $_educationalUse;

    /**
     * @return string
     */
    public function getEducationalUse()
    {
        return $this->_educationalUse;
    }

    /**
     * The purpose of a work in the context of education; for example, 'assignment', 'group work'.
     *
     * @param string $educationalUse
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalUse($educationalUse)
    {
        $this->_educationalUse = $educationalUse;
        return $this;
    }

    private $_encoding;

    /**
     * @return MediaObject
     */
    public function getEncoding()
    {
        return $this->_encoding;
    }

    /**
     * A media object that encodes this CreativeWork. This property is a synonym for associatedMedia.
     * Supersedes encodings.
     *
     * @param MediaObject $encoding
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEncoding($encoding)
    {
        $this->_encoding = $encoding;
        return $this;
    }

    private $_exampleOfWork;

    /**
     * @return CreativeWork
     */
    public function getExampleOfWork()
    {
        return $this->_exampleOfWork;
    }

    /**
     * A creative work that this work is an example/instance/realization/derivation of.
     * Inverse property: workExample.
     *
     * @param CreativeWork $exampleOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExampleOfWork($exampleOfWork)
    {
        $this->_exampleOfWork = $exampleOfWork;
        return $this;
    }

    private $_expires;

    /**
     * @return Date
     */
    public function getExpires()
    {
        return $this->_expires;
    }

    /**
     * Date the content expires and is no longer useful or available. For example a VideoObject or NewsArticle whose
     * availability or relevance is time-limited, or a ClaimReview fact check whose publisher wants to indicate that
     * it may no longer be relevant (or helpful to highlight) after some date.
     *
     * @param Date $expires
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExpires($expires)
    {
        $this->_expires = $expires;
        return $this;
    }

    private $_fileFormat;

    /**
     * @return URL|string
     */
    public function getFileFormat()
    {
        return $this->_fileFormat;
    }

    /**
     * Media type, typically MIME format (see IANA site) of the content e.g. application/zip of a SoftwareApplication
     * binary. In cases where a CreativeWork has several media type representations, 'encoding' can be used to indicate
     * each MediaObject alongside particular fileFormat information. Unregistered or niche file formats can be indicated
     * instead via the most appropriate URL, e.g. defining Web page or a Wikipedia entry.
     *
     * @param URL|string $fileFormat
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFileFormat($fileFormat)
    {
        $this->_fileFormat = $fileFormat;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFunder($funder)
    {
        $this->_funder = $funder;
        return $this;
    }

    private $_genre;

    /**
     * @return URL|string
     */
    public function getGenre()
    {
        return $this->_genre;
    }

    /**
     * Genre of the creative work, broadcast channel or group.
     *
     * @param URL|string $genre
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setGenre($genre)
    {
        $this->_genre = $genre;
        return $this;
    }

    private $_hasPart;

    /**
     * @return CreativeWork
     */
    public function getHasPart()
    {
        return $this->_hasPart;
    }

    /**
     * Indicates a CreativeWork that is (in some sense) a part of this CreativeWork.
     * Inverse property: isPartOf.
     *
     * @param CreativeWork $hasPart
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHasPart($hasPart)
    {
        $this->_hasPart = $hasPart;
        return $this;
    }

    private $_headline;

    /**
     * @return string
     */
    public function getHeadline()
    {
        return $this->_headline;
    }

    /**
     * Headline of the article.
     *
     * @param string $headline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHeadline($headline)
    {
        $this->_headline = $headline;
        return $this;
    }

    private $_inLanguage;

    /**
     * @return Language|string
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
     * @param Language|string $inLanguage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInLanguage($inLanguage)
    {
        $this->_inLanguage = $inLanguage;
        return $this;
    }

    private $_interactionStatistic;

    /**
     * @return InteractionCounter
     */
    public function getInteractionStatistic()
    {
        return $this->_interactionStatistic;
    }

    /**
     * The number of interactions for the CreativeWork using the WebSite or SoftwareApplication.
     * The most specific child type of InteractionCounter should be used.
     *
     * Supersedes interactionCount.
     *
     * @param InteractionCounter $interactionStatistic
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractionStatistic($interactionStatistic)
    {
        $this->_interactionStatistic = $interactionStatistic;
        return $this;
    }

    private $_interactivityType;

    /**
     * @return string
     */
    public function getInteractivityType()
    {
        return $this->_interactivityType;
    }

    /**
     * The predominant mode of learning supported by the learning resource.
     * Acceptable values are 'active', 'expositive', or 'mixed'.
     *
     * @param string $interactivityType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractivityType($interactivityType)
    {
        $this->_interactivityType = $interactivityType;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree)
    {
        $this->_isAccessibleForFree = $isAccessibleForFree;
        return $this;
    }

    private $_isBasedOn;

    /**
     * @return CreativeWork|Product|Url
     */
    public function getisBasedOn()
    {
        return $this->_isBasedOn;
    }

    /**
     * A resource that was used in the creation of this resource. This term can be repeated for multiple sources.
     * For example, http://example.com/great-multiplication-intro.html.
     *
     * Supersedes isBasedOnUrl.
     *
     * @param CreativeWork|Product|Url $isBasedOn
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsBasedOn($isBasedOn)
    {
        $this->_isBasedOn = $isBasedOn;
        return $this;
    }

    private $_isFamilyFriendly;

    /**
     * @return bool
     */
    public function isFamilyFriendly()
    {
        return $this->_isFamilyFriendly;
    }

    /**
     * Indicates whether this content is family friendly.
     *
     * @param bool $isFamilyFriendly
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsFamilyFriendly($isFamilyFriendly)
    {
        $this->_isFamilyFriendly = $isFamilyFriendly;
        return $this;
    }

    private $_isPartOf;

    /**
     * @return CreativeWork
     */
    public function getisPartOf()
    {
        return $this->_isPartOf;
    }

    /**
     * Indicates a CreativeWork that this CreativeWork is (in some sense) part of.
     * Inverse property: hasPart.
     *
     * @param CreativeWork $isPartOf
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsPartOf($isPartOf)
    {
        $this->_isPartOf = $isPartOf;
        return $this;
    }

    private $_keywords;

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    /**
     * Keywords or tags used to describe this content.
     * Multiple entries in a keywords list are typically delimited by commas.
     *
     * @param string $keywords
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
        return $this;
    }

    private $_learningResourceType;

    /**
     * @return string
     */
    public function getLearningResourceType()
    {
        return $this->_learningResourceType;
    }

    /**
     * The predominant type or kind characterizing the learning resource. For example, 'presentation', 'handout'.
     *
     * @param string $learningResourceType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLearningResourceType($learningResourceType)
    {
        $this->_learningResourceType = $learningResourceType;
        return $this;
    }

    private $_license;

    /**
     * @return CreativeWork|URL
     */
    public function getLicense()
    {
        return $this->_license;
    }

    /**
     * A license document that applies to this content, typically indicated by URL.
     *
     * @param CreativeWork|URL $license
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLicense($license)
    {
        $this->_license = $license;
        return $this;
    }

    private $_locationCreated;

    /**
     * @return Place
     */
    public function getLocationCreated()
    {
        return $this->_locationCreated;
    }

    /**
     * The location where the CreativeWork was created, which may not be the same as the location depicted in the CreativeWork.
     *
     * @param Place $locationCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLocationCreated($locationCreated)
    {
        $this->_locationCreated = $locationCreated;
        return $this;
    }

    private $_mainEntity;

    /**
     * @return Thing
     */
    public function getMainEntity()
    {
        return $this->_mainEntity;
    }

    /**
     * Indicates the primary entity described in some page or other CreativeWork.
     * Inverse property: mainEntityOfPage.
     *
     * @param Thing $mainEntity
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMainEntity($mainEntity)
    {
        $this->_mainEntity = $mainEntity;
        return $this;
    }

    private $_material;

    /**
     * @return Product|URL|string
     */
    public function getMaterial()
    {
        return $this->_material;
    }

    /**
     * A material that something is made from, e.g. leather, wool, cotton, paper.
     *
     * @param Product|URL|string $material
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMaterial($material)
    {
        $this->_material = $material;
        return $this;
    }

    private $_mentions;

    /**
     * @return Thing
     */
    public function getMentions()
    {
        return $this->_mentions;
    }

    /**
     * Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.
     *
     * @param Thing $mentions
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMentions($mentions)
    {
        $this->_mentions = $mentions;
        return $this;
    }

    private $_offers;

    /**
     * @return Offer
     */
    public function getOffers()
    {
        return $this->_offers;
    }

    /**
     * An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie,
     * perform a service, or give away tickets to an event.
     *
     * @param Offer $offers
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setOffers($offers)
    {
        $this->_offers = $offers;
        return $this;
    }

    private $_position;

    /**
     * @return int|string
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * The position of an item in a series or sequence of items.
     *
     * @param int|string $position
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPosition($position)
    {
        $this->_position = $position;
        return $this;
    }

    private $_producer;

    /**
     * @return Organization|Person
     */
    public function getProducer()
    {
        return $this->_producer;
    }

    /**
     * The person or organization who produced the work (e.g. music album, movie, tv/radio series etc.).
     *
     * @param Organization|Person $producer
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProducer($producer)
    {
        $this->_producer = $producer;
        return $this;
    }

    private $_provider;

    /**
     * @return Organization|Person
     */
    public function getProvider()
    {
        return $this->_provider;
    }

    /**
     * The service provider, service operator, or service performer; the goods producer. Another party (a seller)
     * may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * Supersedes carrier.
     *
     * @param Organization|Person $provider
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProvider($provider)
    {
        $this->_provider = $provider;
        return $this;
    }

    private $_publication;

    /**
     * @return PublicationEvent
     */
    public function getPublication()
    {
        return $this->_publication;
    }

    /**
     * A publication event associated with the item.
     *
     * @param PublicationEvent $publication
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublication($publication)
    {
        $this->_publication = $publication;
        return $this;
    }

    private $_publisher;

    /**
     * @return Organization|Person
     */
    public function getPublisher()
    {
        return $this->_publisher;
    }

    /**
     * The publisher of the creative work.
     *
     * @param Organization|Person $publisher
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisher($publisher)
    {
        $this->_publisher = $publisher;
        return $this;
    }

    private $_publisherImprint;

    /**
     * @return Organization
     */
    public function getPublisherImprint()
    {
        return $this->_publisherImprint;
    }

    /**
     * The publishing division which published the comic.
     *
     * @param Organization $publisherImprint
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisherImprint($publisherImprint)
    {
        $this->_publisherImprint = $publisherImprint;
        return $this;
    }

    private $_publishingPrinciples;

    /**
     * @return CreativeWork|URL
     */
    public function getPublishingPrinciples()
    {
        return $this->_publishingPrinciples;
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
     * @param CreativeWork|URL $publishingPrinciples
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublishingPrinciples($publishingPrinciples)
    {
        $this->_publishingPrinciples = $publishingPrinciples;
        return $this;
    }

    private $_recordedAt;

    /**
     * @return Event
     */
    public function getRecordedAt()
    {
        return $this->_recordedAt;
    }

    /**
     * The Event where the CreativeWork was recorded. The CreativeWork may capture all or part of the event.
     * Inverse property: recordedIn.
     *
     * @param Event $recordedAt
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setRecordedAt($recordedAt)
    {
        $this->_recordedAt = $recordedAt;
        return $this;
    }

    private $_releasedEvent;

    /**
     * @return PublicationEvent
     */
    public function getReleasedEvent()
    {
        return $this->_releasedEvent;
    }

    /**
     * The place and time the release was issued, expressed as a PublicationEvent.
     *
     * @param PublicationEvent $releasedEvent
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReleasedEvent($releasedEvent)
    {
        $this->_releasedEvent = $releasedEvent;
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
     * 	A review of the item. Supersedes reviews.
     *
     * @param Review $review
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReview($review)
    {
        $this->_review = $review;
        return $this;
    }

    private $_schemaVersion;

    /**
     * @return URL|string
     */
    public function getSchemaVersion()
    {
        return $this->_schemaVersion;
    }

    /**
     * Indicates (by URL or string) a particular version of a schema used in some CreativeWork.
     * For example, a document could declare a schemaVersion using an URL such as http://schema.org/version/2.0/
     * if precise indication of schema version was required by some application.
     *
     * @param URL|string $schemaVersion
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSchemaVersion($schemaVersion)
    {
        $this->_schemaVersion = $schemaVersion;
        return $this;
    }

    private $_sourceOrganization;

    /**
     * @return Organization
     */
    public function getSourceOrganization()
    {
        return $this->_sourceOrganization;
    }

    /**
     * The Organization on whose behalf the creator was working.
     *
     * @param Organization $sourceOrganization
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSourceOrganization($sourceOrganization)
    {
        $this->_sourceOrganization = $sourceOrganization;
        return $this;
    }

    private $_spatialCoverage;

    /**
     * @return Place
     */
    public function getSpatialCoverage()
    {
        return $this->_spatialCoverage;
    }

    /**
     * The spatialCoverage of a CreativeWork indicates the place(s) which are the focus of the content.
     * It is a subproperty of contentLocation intended primarily for more technical and detailed materials.
     * For example with a Dataset, it indicates areas that the dataset describes: a dataset of New York weather would
     * have spatialCoverage which was the place: the state of New York. Supersedes spatial.
     *
     * @param Place $spatialCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSpatialCoverage($spatialCoverage)
    {
        $this->_spatialCoverage = $spatialCoverage;
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor = $sponsor;
        return $this;
    }

    private $_temporalCoverage;

    /**
     * @return DateTime|URL|string
     */
    public function getTemporalCoverage()
    {
        return $this->_temporalCoverage;
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
     * @param DateTime|URL|string $temporalCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTemporalCoverage($temporalCoverage)
    {
        $this->_temporalCoverage = $temporalCoverage;
        return $this;
    }

    private $_text;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * The textual content of this CreativeWork.
     *
     * @param string $text
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    private $_thumbnailUrl;

    /**
     * @return URL
     */
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }

    /**
     * 	A thumbnail image relevant to the Thing.
     *
     * @param URL $thumbnailUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->_thumbnailUrl = $thumbnailUrl;
        return $this;
    }

    private $_timeRequired;

    /**
     * @return Duration
     */
    public function getTimeRequired()
    {
        return $this->_timeRequired;
    }

    /**
     * Approximate or typical time it takes to work with or through this learning resource for the typical intended
     * target audience, e.g. 'P30M', 'P1H25M'.
     *
     * @param Duration $timeRequired
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTimeRequired($timeRequired)
    {
        $this->_timeRequired = $timeRequired;
        return $this;
    }

    private $_translationOfWork;

    /**
     * @return CreativeWork
     */
    public function getTranslationOfWork()
    {
        return $this->_translationOfWork;
    }

    /**
     * The work that this work has been translated from. e.g. 物种起源 is a translationOf “On the Origin of Species”
     * Inverse property: workTranslation.
     *
     * @param CreativeWork $translationOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTranslationOfWork($translationOfWork)
    {
        $this->_translationOfWork = $translationOfWork;
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
     * Organization or person who adapts a creative work to different languages, regional differences and technical
     * requirements of a target market, or that translates during some event.
     *
     * @param Organization|Person $translator
     * @return CreativeWork|CreativeWorkTrait
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
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTypicalAgeRange($typicalAgeRange)
    {
        $this->_typicalAgeRange = $typicalAgeRange;
        return $this;
    }

    private $_version;

    /**
     * @return int|string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * The version of the CreativeWork embodied by a specified resource.
     *
     * @param int|string $version
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    private $_video;

    /**
     * @return VideoObject
     */
    public function getVideo()
    {
        return $this->_video;
    }

    /**
     * 	An embedded video object.
     *
     * @param VideoObject $video
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVideo($video)
    {
        $this->_video = $video;
        return $this;
    }

    private $_workExample;

    /**
     * @return CreativeWork
     */
    public function getWorkExample()
    {
        return $this->_workExample;
    }

    /**
     * Example/instance/realization/derivation of the concept of this creative work.
     * eg. The paperback edition, first edition, or eBook.
     * Inverse property: exampleOfWork.
     *
     * @param CreativeWork $workExample
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkExample($workExample)
    {
        $this->_workExample = $workExample;
        return $this;
    }

    private $_workTranslation;

    /**
     * @return CreativeWork
     */
    public function getWorkTranslation()
    {
        return $this->_workTranslation;
    }

    /**
     * A work that is a translation of the content of this work. e.g. 西遊記 has an English workTranslation “Journey to
     * the West”,a German workTranslation “Monkeys Pilgerfahrt” and a Vietnamese translation Tây du ký bình khảo.
     * Inverse property: translationOfWork.
     *
     * @param CreativeWork $workTranslation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkTranslation($workTranslation)
    {
        $this->_workTranslation = $workTranslation;
        return $this;
    }
}
