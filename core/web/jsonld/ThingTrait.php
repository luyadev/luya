<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Thing trait
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait ThingTrait
{
    private $_additionalType;

    /**
     * @return URL
     */
    public function getAdditionalType()
    {
        return $this->_additionalType;
    }

    /**
     * An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax.
     * This is a relationship between something and a class that the thing is in.
     *
     * @param string $additionalType
     * @return Thing
     */
    public function setAdditionalType($additionalType)
    {
        $this->_additionalType = $additionalType;
        return $this;
    }

    private $_alternateName;

    /**
     * @return string
     */
    public function getAlternateName()
    {
        return $this->_alternateName;
    }

    /**
     * An alias for the item
     *
     * @param string $alternateName
     * @return Thing
     */
    public function setAlternateName($alternateName)
    {
        $this->_alternateName = $alternateName;
        return $this;
    }

    private $_description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * A description of the item.
     *
     * @param string $description
     * @return Thing
     */
    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    private $_disambiguatingDescription;

    /**
     * @return string
     */
    public function getDisambiguatingDescription()
    {
        return $this->_disambiguatingDescription;
    }

    /**
     * A sub property of description. A short description of the item used to disambiguate from other, similar items.
     * Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.
     *
     * @param string $disambiguatingDescription
     * @return Thing
     */
    public function setDisambiguatingDescription($disambiguatingDescription)
    {
        $this->_disambiguatingDescription = $disambiguatingDescription;
        return $this;
    }

    private $_identifier;

    /**
     * @return PropertyValue|URL|string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties for representing many of these, either as textual strings or as URL (URI) links. See background notes for more details.
     *
     * @param PropertyValue|URL|string $identifier
     * @return Thing
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    private $_image;

    /**
     * @return ImageObject|URL
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * An image of the item.
     * This can be a URL or a fully described ImageObject.
     *
     * @param ImageObject|URL $image
     * @return Thing
     */
    public function setImage($image)
    {
        $this->_image = $image;
        return $this;
    }

    private $_mainEntityOfPage;

    /**
     * @return CreativeWork|URL
     */
    public function getMainEntityOfPage()
    {
        return $this->_mainEntityOfPage;
    }

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main entity being described.
     * Inverse property: mainEntity.
     *
     * @param CreativeWork|URL $mainEntityOfPage
     * @return Thing
     */
    public function setMainEntityOfPage($mainEntityOfPage)
    {
        $this->_mainEntityOfPage = $mainEntityOfPage;
        return $this;
    }

    private $_name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * The name of the item.
     *
     * @param string $name
     * @return Thing
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    private $_potentialAction;

    /**
     * @return Action
     */
    public function getPotentialAction()
    {
        return $this->_potentialAction;
    }

    /**
     * 	Indicates a potential Action, which describes an idealized action in which this thing would play an 'object' role.
     *
     * @param Action $potentialAction
     * @return Thing
     */
    public function setPotentialAction($potentialAction)
    {
        $this->_potentialAction = $potentialAction;
        return $this;
    }

    private $_sameAs;

    /**
     * @return URL
     */
    public function getSameAs()
    {
        return $this->_sameAs;
    }

    /**
     * URL of a reference Web page that unambiguously indicates the item's identity.
     * E.g. the URL of the item's Wikipedia page, Wikidata entry, or official website.
     *
     * @param URL $sameAs
     * @return Thing
     */
    public function setSameAs($sameAs)
    {
        $this->_sameAs = $sameAs;
        return $this;
    }

    private $_subjectOf;

    /**
     * @return CreativeWork|Event
     */
    public function getSubjectOf()
    {
        return $this->_subjectOf;
    }

    /**
     * A CreativeWork or Event about this Thing.
     * Inverse property: about.
     *
     * @param CreativeWork|Event $subjectOf
     * @return Thing
     */
    public function setSubjectOf($subjectOf)
    {
        $this->_subjectOf = $subjectOf;
        return $this;
    }

    private $_url;

    /**
     * @return URL
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * URL of the item.
     *
     * @param URL $url
     * @return Thing
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }
}
