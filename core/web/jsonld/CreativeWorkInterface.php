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
    public function setAbout($about);

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
    public function setAccountablePerson($accountablePerson);

    /**
     * @return AggregateRating
     */
    public function getAggregateRating();

    /**
     * @param AggregateRating $aggregateRating
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAggregateRating($aggregateRating);

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
    public function setAssociatedMedia($associatedMedia);

    /**
     * @return Audience
     */
    public function getAudience();

    /**
     * @param Audience $audience
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudience($audience);

    /**
     * @return AudioObject
     */
    public function getAudio();

    /**
     * @param AudioObject $audio
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setAudio($audio);

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
    public function setCharacter($character);

    /**
     * @return CreativeWork|string
     */
    public function getCitation();

    /**
     * @param CreativeWork|string $citation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setCitation($citation);

    /**
     * @return Comment
     */
    public function getComment();

    /**
     * @param Comment $comment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setComment($comment);

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
    public function setContentLocation($contentLocation);

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
     * @return DateTime
     */
    public function getContentReferenceTime();

    /**
     * @param DateTime $contentReferenceTime
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setContentReferenceTime($contentReferenceTime);

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
     * @return Date|DateTime
     */
    public function getDateCreated();

    /**
     * @param Date|DateTime $dateCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateCreated($dateCreated);

    /**
     * @return Date|DateTime
     */
    public function getDateModified();

    /**
     * @param Date|DateTime $dateModified
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDateModified($dateModified);

    /**
     * @return Date
     */
    public function getDatePublished();

    /**
     * @param Date $datePublished
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDatePublished($datePublished);

    /**
     * @return URL
     */
    public function getDiscussionUrl();

    /**
     * @param URL $discussionUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setDiscussionUrl($discussionUrl);

    /**
     * @return Person
     */
    public function getEditor();

    /**
     * @param Person $editor
     */
    public function setEditor($editor);

    /**
     * @return AlignmentObject
     */
    public function getEducationalAlignment();

    /**
     * @param AlignmentObject $educationalAlignment
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalAlignment($educationalAlignment);

    /**
     * @return string
     */
    public function getEducationalUse();

    /**
     * @param string $educationalUse
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEducationalUse($educationalUse);

    /**
     * @return MediaObject
     */
    public function getEncoding();

    /**
     * @param MediaObject $encoding
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setEncoding($encoding);

    /**
     * @return CreativeWork
     */
    public function getExampleOfWork();

    /**
     * @param CreativeWork $exampleOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExampleOfWork($exampleOfWork);

    /**
     * @return Date
     */
    public function getExpires();

    /**
     * @param Date $expires
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setExpires($expires);

    /**
     * @return URL|string
     */
    public function getFileFormat();

    /**
     * @param URL|string $fileFormat
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFileFormat($fileFormat);

    /**
     * @return Organization|Person
     */
    public function getFunder();

    /**
     * @param Organization|Person $funder
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setFunder($funder);

    /**
     * @return URL|string
     */
    public function getGenre();

    /**
     * @param URL|string $genre
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
    public function setHasPart($hasPart);

    /**
     * @return string
     */
    public function getHeadline();

    /**
     * @param string $headline
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setHeadline($headline);

    /**
     * @return Language|string
     */
    public function getInLanguage();

    /**
     * @param Language|string $inLanguage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInLanguage($inLanguage);

    /**
     * @return InteractionCounter
     */
    public function getInteractionStatistic();

    /**
     * @param InteractionCounter $interactionStatistic
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setInteractionStatistic($interactionStatistic);

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
     * @return CreativeWork|Product|Url
     */
    public function getisBasedOn();

    /**
     * @param CreativeWork|Product|Url $isBasedOn
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setIsBasedOn($isBasedOn);

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
    public function setIsPartOf($isPartOf);

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
     * @return CreativeWork|URL
     */
    public function getLicense();

    /**
     * @param CreativeWork|URL $license
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLicense($license);

    /**
     * @return Place
     */
    public function getLocationCreated();

    /**
     * @param Place $locationCreated
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setLocationCreated($locationCreated);

    /**
     * @return Thing
     */
    public function getMainEntity();

    /**
     * @param Thing $mainEntity
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMainEntity($mainEntity);

    /**
     * @return Product|URL|string
     */
    public function getMaterial();

    /**
     * @param Product|URL|string $material
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMaterial($material);

    /**
     * @return Thing
     */
    public function getMentions();

    /**
     * @param Thing $mentions
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setMentions($mentions);

    /**
     * @return Offer
     */
    public function getOffers();

    /**
     * @param Offer $offers
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setOffers($offers);

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
     * @return PublicationEvent
     */
    public function getPublication();

    /**
     * @param PublicationEvent $publication
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublication($publication);

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
    public function setPublisherImprint($publisherImprint);

    /**
     * @return CreativeWork|URL
     */
    public function getPublishingPrinciples();

    /**
     * @param CreativeWork|URL $publishingPrinciples
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setPublishingPrinciples($publishingPrinciples);

    /**
     * @return Event
     */
    public function getRecordedAt();

    /**
     * @param Event $recordedAt
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setRecordedAt($recordedAt);

    /**
     * @return PublicationEvent
     */
    public function getReleasedEvent();

    /**
     * @param PublicationEvent $releasedEvent
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReleasedEvent($releasedEvent);

    /**
     * @return Review
     */
    public function getReview();

    /**
     * @param Review $review
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setReview($review);

    /**
     * @return URL|string
     */
    public function getSchemaVersion();

    /**
     * @param URL|string $schemaVersion
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSchemaVersion($schemaVersion);

    /**
     * @return Organization
     */
    public function getSourceOrganization();

    /**
     * @param Organization $sourceOrganization
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSourceOrganization($sourceOrganization);

    /**
     * @return Place
     */
    public function getSpatialCoverage();

    /**
     * @param Place $spatialCoverage
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setSpatialCoverage($spatialCoverage);

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
     * @return URL
     */
    public function getThumbnailUrl();

    /**
     * @param URL $thumbnailUrl
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setThumbnailUrl($thumbnailUrl);

    /**
     * @return Duration
     */
    public function getTimeRequired();

    /**
     * @param Duration $timeRequired
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTimeRequired($timeRequired);

    /**
     * @return CreativeWork
     */
    public function getTranslationOfWork();

    /**
     * @param CreativeWork $translationOfWork
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setTranslationOfWork($translationOfWork);

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
     * @return VideoObject
     */
    public function getVideo();

    /**
     * @param VideoObject $video
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setVideo($video);

    /**
     * @return CreativeWork
     */
    public function getWorkExample();

    /**
     * @param CreativeWork $workExample
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkExample($workExample);

    /**
     * @return CreativeWork
     */
    public function getWorkTranslation();

    /**
     * @param CreativeWork $workTranslation
     * @return CreativeWork|CreativeWorkTrait
     */
    public function setWorkTranslation($workTranslation);
}