<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Creative Work Interface
 *
 * @see http://schema.org/CreativeWork
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
interface CreativeWorkInterface extends ThingInterface
{
    /**
     * @return Thing
     */
    public function getAbout();

    /**
     * @param Thing $about
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAbout(Thing $about);

    /**
     * @return string
     */
    public function getAccessMode();

    /**
     * @param string $accessMode
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessMode($accessMode);

    /**
     * @return string
     */
    public function getAccessModeSufficient();

    /**
     * @param string $accessModeSufficient
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessModeSufficient($accessModeSufficient);

    /**
     * @return string
     */
    public function getAccessibilityAPI();

    /**
     * @param string $accessibilityAPI
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityAPI($accessibilityAPI);

    /**
     * @return string
     */
    public function getAccessibilityControl();

    /**
     * @param string $accessibilityControl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityControl($accessibilityControl);

    /**
     * @return string
     */
    public function getAccessibilityFeature();

    /**
     * @param string $accessibilityFeature
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityFeature($accessibilityFeature);

    /**
     * @return string
     */
    public function getAccessibilityHazard();

    /**
     * @param string $accessibilityHazard
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilityHazard($accessibilityHazard);

    /**
     * @return string
     */
    public function getAccessibilitySummary();

    /**
     * @param string $accessibilitySummary
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccessibilitySummary($accessibilitySummary);

    /**
     * @return Person
     */
    public function getAccountablePerson();

    /**
     * @param Person $accountablePerson
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAccountablePerson(Person $accountablePerson);

    /**
     * @return string
     */
    public function getAlternativeHeadline();

    /**
     * @param string $alternativeHeadline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAlternativeHeadline($alternativeHeadline);

    /**
     * @return MediaObject
     */
    public function getAssociatedMedia();

    /**
     * @param MediaObject $associatedMedia
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAssociatedMedia(MediaObject $associatedMedia);

    /**
     * @return Organization|Person
     */
    public function getAuthor();

    /**
     * @param Organization|Person $author
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAuthor($author);

    /**
     * @return string
     */
    public function getAward();

    /**
     * @param string $award
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAward($award);

    /**
     * @return Person
     */
    public function getCharacter();

    /**
     * @param Person $character
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCharacter(Person $character);

    /**
     * @return CreativeWork|string
     */
    public function getCitation();

    /**
     * @param CreativeWork|string $citation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCitation(CreativeWork $citation);

    /**
     * @return Comment
     */
    public function getComment();

    /**
     * @param Comment $comment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setComment(Comment $comment);

    /**
     * @return int
     */
    public function getCommentCount();

    /**
     * @param int $commentCount
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCommentCount($commentCount);

    /**
     * @return Place
     */
    public function getContentLocation();

    /**
     * @param Place $contentLocation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentLocation(Place $contentLocation);

    /**
     * @return string
     */
    public function getContentRating();

    /**
     * @param string $contentRating
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentRating($contentRating);

    /**
     * @return string
     */
    public function getContentReferenceTime();

    /**
     * @param DateTimeValue $contentReferenceTime
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentReferenceTime(DateTimeValue $contentReferenceTime);

    /**
     * @return Organization|Person
     */
    public function getContributor();

    /**
     * @param Organization|Person $contributor
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContributor($contributor);

    /**
     * @return Organization|Person
     */
    public function getCopyrightHolder();

    /**
     * @param Organization|Person $copyrightHolder
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightHolder($copyrightHolder);

    /**
     * @return mixed
     */
    public function getCopyrightYear();

    /**
     * @param mixed $copyrightYear
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCopyrightYear($copyrightYear);

    /**
     * @return Organization|Person
     */
    public function getCreator();

    /**
     * @param Organization|Person $creator
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCreator($creator);

    /**
     * @return string
     */
    public function getDateCreated();

    /**
     * @param DateTimeValue $dateCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateCreated(DateTimeValue $dateCreated);

    /**
     * @return string
     */
    public function getDateModified();

    /**
     * @param DateTimeValue $dateModified
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateModified(DateTimeValue $dateModified);

    /**
     * @return string
     */
    public function getDatePublished();

    /**
     * @param DateTimeValue $datePublished
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDatePublished(DateTimeValue $datePublished);

    /**
     * @return string
     */
    public function getDiscussionUrl();

    /**
     * @param UrlValue $discussionUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDiscussionUrl(UrlValue $discussionUrl);

    /**
     * @return Person
     */
    public function getEditor();

    /**
     * @param Person $editor
     */
    public function setEditor(Person $editor);

    /**
     * @return CreativeWork
     */
    public function getEducationalUse();

    /**
     * @param string $educationalUse
     * @return CreativeWork
     */
    public function setEducationalUse(CreativeWork $educationalUse);

    /**
     * @return MediaObject
     */
    public function getEncoding();

    /**
     * @param MediaObject $encoding
     * @return CreativeWork
     */
    public function setEncoding(MediaObject $encoding);

    /**
     * @return CreativeWork
     */
    public function getExampleOfWork();

    /**
     * @param CreativeWork $exampleOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExampleOfWork(CreativeWork $exampleOfWork);

    /**
     * @return string
     */
    public function getExpires();

    /**
     * @param DateValue $expires
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExpires(DateValue $expires);

    /**
     * @return string
     */
    public function getFileFormat();

    /**
     * @param string $fileFormat
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFileFormat($fileFormat);

    /**
     * @return string
     */
    public function getGenre();

    /**
     * @param string $genre
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setGenre($genre);

    /**
     * @return CreativeWork
     */
    public function getHasPart();

    /**
     * @param CreativeWork $hasPart
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHasPart(CreativeWork $hasPart);

    /**
     * @return string
     */
    public function getHeadline();

    /**
     * @param TextValue $headline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHeadline(TextValue $headline);

    /**
     * @return string
     */
    public function getInteractivityType();

    /**
     * @param string $interactivityType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractivityType($interactivityType);

    /**
     * @return bool
     */
    public function isAccessibleForFree();

    /**
     * @param bool $isAccessibleForFree
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsAccessibleForFree($isAccessibleForFree);

    /**
     * @return bool
     */
    public function isFamilyFriendly();

    /**
     * @param bool $isFamilyFriendly
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsFamilyFriendly($isFamilyFriendly);

    /**
     * @return CreativeWork
     */
    public function getisPartOf();

    /**
     * @param CreativeWork $isPartOf
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsPartOf(CreativeWork $isPartOf);

    /**
     * @return string
     */
    public function getKeywords();

    /**
     * @param string $keywords
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setKeywords($keywords);

    /**
     * @return string
     */
    public function getLearningResourceType();

    /**
     * @param string $learningResourceType
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLearningResourceType($learningResourceType);

    /**
     * @return Place
     */
    public function getLocationCreated();

    /**
     * @param Place $locationCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLocationCreated(Place $locationCreated);

    /**
     * @return Thing
     */
    public function getMainEntity();

    /**
     * @param Thing $mainEntity
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMainEntity(Thing $mainEntity);

    /**
     * @return Thing
     */
    public function getMentions();

    /**
     * @param Thing $mentions
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMentions(Thing $mentions);

    /**
     * @return int|string
     */
    public function getPosition();

    /**
     * @param int|string $position
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPosition($position);

    /**
     * @return Organization|Person
     */
    public function getProducer();

    /**
     * @param Organization|Person $producer
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProducer($producer);

    /**
     * @return Organization|Person
     */
    public function getProvider();

    /**
     * @param Organization|Person $provider
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setProvider($provider);

    /**
     * @return Organization|Person
     */
    public function getPublisher();

    /**
     * @param Organization|Person $publisher
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisher($publisher);

    /**
     * @return Organization
     */
    public function getPublisherImprint();

    /**
     * @param Organization $publisherImprint
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublisherImprint(Organization $publisherImprint);

    /**
     * @return CreativeWork
     */
    public function getPublishingPrinciples();

    /**
     * @param CreativeWork $publishingPrinciples
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublishingPrinciples(CreativeWork $publishingPrinciples);

    /**
     * @return Event
     */
    public function getRecordedAt();

    /**
     * @param Event $recordedAt
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setRecordedAt(Event $recordedAt);


    /**
     * @return string
     */
    public function getSchemaVersion();

    /**
     * @param string $schemaVersion
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSchemaVersion(UrlValue $schemaVersion);

    /**
     * @return Organization
     */
    public function getSourceOrganization();

    /**
     * @param Organization $sourceOrganization
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSourceOrganization(Organization $sourceOrganization);

    /**
     * @return Place
     */
    public function getSpatialCoverage();

    /**
     * @param Place $spatialCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSpatialCoverage(Place $spatialCoverage);

    /**
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSponsor($sponsor);

    /**
     * @return DateTime|URL|string
     */
    public function getTemporalCoverage();

    /**
     * @param DateTime|URL|string $temporalCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTemporalCoverage($temporalCoverage);

    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setText($text);

    /**
     * @return string
     */
    public function getThumbnailUrl();

    /**
     * @param UrlValue $thumbnailUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setThumbnailUrl(UrlValue $thumbnailUrl);
    
    /**
     * @return CreativeWork
     */
    public function getTranslationOfWork();

    /**
     * @param CreativeWork $translationOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTranslationOfWork(CreativeWork $translationOfWork);

    /**
     * @return Organization|Person
     */
    public function getTranslator();

    /**
     * @param Organization|Person $translator
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTranslator($translator);

    /**
     * @return string
     */
    public function getTypicalAgeRange();

    /**
     * @param string $typicalAgeRange
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTypicalAgeRange($typicalAgeRange);

    /**
     * @return int|string
     */
    public function getVersion();

    /**
     * @param int|string $version
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVersion($version);
    
    /**
     * @return CreativeWork
     */
    public function getWorkExample();

    /**
     * @param CreativeWork $workExample
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkExample(CreativeWork $workExample);

    /**
     * @return CreativeWork
     */
    public function getWorkTranslation();

    /**
     * @param CreativeWork $workTranslation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkTranslation(CreativeWork $workTranslation);
}
