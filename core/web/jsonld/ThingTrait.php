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
    /**
     * An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax.
     * This is a relationship between something and a class that the thing is in.
     *
     * @var URL
     */
    private $_additionalType;

    /**
     * @return URL
     */
    public function getAdditionalType()
    {
        return $this->_additionalType;
    }

    /**
     * @param URL $additionalType
     * @return Thing
     */
    public function setAdditionalType(URL $additionalType)
    {
        $this->_additionalType = $additionalType;
        return $this;
    }

    /**
     * An alias for the item
     *
     * @var string
     */
    private $_alternateName;

    /**
     * @return string
     */
    public function getAlternateName()
    {
        return $this->_alternateName;
    }

    /**
     * @param string $alternateName
     * @return Thing
     */
    public function setAlternateName(string $alternateName)
    {
        $this->_alternateName = $alternateName;
        return $this;
    }

    /**
     * A description of the item.
     *
     * @var string
     */
    private $_description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param string $description
     * @return Thing
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
        return $this;
    }

    /**
     * A sub property of description. A short description of the item used to disambiguate from other, similar items.
     * Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.
     *
     * @var string
     */
    private $_disambiguatingDescription;

    /**
     * @return string
     */
    public function getDisambiguatingDescription()
    {
        return $this->_disambiguatingDescription;
    }

    /**
     * @param string $disambiguatingDescription
     * @return Thing
     */
    public function setDisambiguatingDescription(string $disambiguatingDescription)
    {
        $this->_disambiguatingDescription = $disambiguatingDescription;
        return $this;
    }

    /**
     * The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties for representing many of these, either as textual strings or as URL (URI) links. See background notes for more details.
     *
     * @var PropertyValue|string|URL
     */
    private $_identifier;

    /**
     * @return PropertyValue|URL|string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * @param PropertyValue|URL|string $identifier
     * @return Thing
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    /**
     * An image of the item.
     * This can be a URL or a fully described ImageObject.
     *
     * @var ImageObject|URL
     */
    private $_image;

    /**
     * @return ImageObject|URL
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param ImageObject|URL $image
     * @return Thing
     */
    public function setImage($image)
    {
        $this->_image = $image;
        return $this;
    }

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main entity being described.
     * Inverse property: mainEntity.
     *
     * @var CreativeWork|URL
     */
    private $_mainEntityOfPage;

    /**
     * @return CreativeWork|URL
     */
    public function getMainEntityOfPage()
    {
        return $this->_mainEntityOfPage;
    }

    /**
     * @param CreativeWork|URL $mainEntityOfPage
     * @return Thing
     */
    public function setMainEntityOfPage($mainEntityOfPage)
    {
        $this->_mainEntityOfPage = $mainEntityOfPage;
        return $this;
    }

    /**
     * The name of the item.
     *
     * @var string
     */
    private $_name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     * @return Thing
     */
    public function setName(string $name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * 	Indicates a potential Action, which describes an idealized action in which this thing would play an 'object' role.
     *
     * @var Action
     */
    private $_potentialAction;

    /**
     * @return Action
     */
    public function getPotentialAction()
    {
        return $this->_potentialAction;
    }

    /**
     * @param Action $potentialAction
     * @return Thing
     */
    public function setPotentialAction(Action $potentialAction)
    {
        $this->_potentialAction = $potentialAction;
        return $this;
    }

    /**
     * URL of a reference Web page that unambiguously indicates the item's identity.
     * E.g. the URL of the item's Wikipedia page, Wikidata entry, or official website.
     *
     * @var URL
     */
    private $_sameAs;

    /**
     * @return URL
     */
    public function getSameAs()
    {
        return $this->_sameAs;
    }

    /**
     * @param URL $sameAs
     * @return Thing
     */
    public function setSameAs(URL $sameAs)
    {
        $this->_sameAs = $sameAs;
        return $this;
    }

    /**
     * A CreativeWork or Event about this Thing.
     * Inverse property: about.
     *
     * @var CreativeWork|Event
     */
    private $_subjectOf;

    /**
     * @return CreativeWork|Event
     */
    public function getSubjectOf()
    {
        return $this->_subjectOf;
    }

    /**
     * @param CreativeWork|Event $subjectOf
     * @return Thing
     */
    public function setSubjectOf($subjectOf)
    {
        $this->_subjectOf = $subjectOf;
        return $this;
    }

    /**
     * URL of the item.
     *
     * @var URL
     */
    private $_url;

    /**
     * @return URL
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param URL $url
     * @return Thing
     */
    public function setUrl(URL $url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * Return the fields
     */
    public function fields()
    {
        return ['additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'name', 'potentialAction', 'sameAs', 'subjectOf', 'url'];
    }
}