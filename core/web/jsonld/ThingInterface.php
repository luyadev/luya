<?php

namespace luya\web\jsonld;

/**
* JsonLd - Thing interface
*
* @author Alex Schmid
* @since 1.0.0
*/
interface ThingInterface
{
    /**
     * @return URL
     */
    public function getAdditionalType();

    /**
     * @param URL $additionalType
     * @return Thing
     */
    public function setAdditionalType($additionalType);

    /**
     * @return string
     */
    public function getAlternateName();

    /**
     * @param string $alternateName
     * @return Thing
     */
    public function setAlternateName($alternateName);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return Thing
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDisambiguatingDescription();

    /**
     * @param string $disambiguatingDescription
     * @return Thing
     */
    public function setDisambiguatingDescription($disambiguatingDescription);

    /**
     * @return PropertyValue|URL|string
     */
    public function getIdentifier();

    /**
     * @param PropertyValue|URL|string $identifier
     * @return Thing
     */
    public function setIdentifier($identifier);

    /**
     * @return ImageObject|URL
     */
    public function getImage();

    /**
     * @param ImageObject|URL $image
     * @return Thing
     */
    public function setImage($image);

    /**
     * @return CreativeWork|URL
     */
    public function getMainEntityOfPage();

    /**
     * @param CreativeWork|URL $mainEntityOfPage
     * @return Thing
     */
    public function setMainEntityOfPage($mainEntityOfPage);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return Thing
     */
    public function setName($name);

    /**
     * @return Action
     */
    public function getPotentialAction();

    /**
     * @param Action $potentialAction
     * @return Thing
     */
    public function setPotentialAction($potentialAction);

    /**
     * @return URL
     */
    public function getSameAs();

    /**
     * @param URL $sameAs
     * @return Thing
     */
    public function setSameAs($sameAs);

    /**
     * @return CreativeWork|Event
     */
    public function getSubjectOf();

    /**
     * @param CreativeWork|Event $subjectOf
     * @return Thing
     */
    public function setSubjectOf($subjectOf);

    /**
     * @return URL
     */
    public function getUrl();

    /**
     * @param URL $url
     * @return Thing
     */
    public function setUrl($url);
}