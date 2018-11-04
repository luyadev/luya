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
     * @return string
     */
    public function getAdditionalType();

    /**
     * @param UrlValue $additionalType
     * @return static
     */
    public function setAdditionalType(UrlValue $additionalType);

    /**
     * @return string
     */
    public function getAlternateName();

    /**
     * @param string $alternateName
     * @return static
     */
    public function setAlternateName($alternateName);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return static
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDisambiguatingDescription();

    /**
     * @param string $disambiguatingDescription
     * @return static
     */
    public function setDisambiguatingDescription($disambiguatingDescription);

    /**
     * @return PropertyValue
     */
    public function getIdentifier();

    /**
     * @param PropertyValue
     * @return static
     */
    public function setIdentifier(PropertyValue $identifier);

    /**
     * @return ImageObject
     */
    public function getImage();

    /**
     * @param ImageObject $image
     * @return static
     */
    public function setImage(ImageObject $image);

    /**
     * @return CreativeWork
     */
    public function getMainEntityOfPage();

    /**
     * @param CreativeWork $mainEntityOfPage
     * @return static
     */
    public function setMainEntityOfPage(CreativeWork $mainEntityOfPage);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return static
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getSameAs();

    /**
     * @param UrlValue $sameAs
     * @return static
     */
    public function setSameAs(UrlValue $sameAs);

    /**
     * @return CreativeWork|Event
     */
    public function getSubjectOf();

    /**
     * @param CreativeWork|Event $subjectOf
     * @return static
     */
    public function setSubjectOf($subjectOf);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param UrlValue $url
     * @return static
     */
    public function setUrl(UrlValue $url);
}
