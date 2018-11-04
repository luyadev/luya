<?php

namespace luya\web\jsonld;

use luya\helpers\ObjectHelper;

/**
 * JsonLd - Person trait
 *
 * @see http://schema.org/Person
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait PersonTrait
{
    private $_additionalName;

    /**
     * @return string
     */
    public function getAdditionalName()
    {
        return $this->_additionalName;
    }

    /**
     * An additional name for a Person, can be used for a middle name.
     *
     * @param string $additionalName
     * @return static
     */
    public function setAdditionalName($additionalName)
    {
        $this->_additionalName = $additionalName;
        return $this;
    }

    private $_address;

    /**
     * @return PostalAddress|string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Physical address of the item.
     *
     * @param PostalAddress|string $address
     * @return static
     */
    public function setAddress(PostalAddress $address)
    {
        $this->_address = $address;
        return $this;
    }

    private $_affiliation;

    /**
     * @return Organization
     */
    public function getAffiliation()
    {
        return $this->_affiliation;
    }

    /**
     * An organization that this person is affiliated with. For example, a school/university, a club, or a team.
     *
     * @param Organization $affiliation
     * @return static
     */
    public function setAffiliation(Organization $affiliation)
    {
        $this->_affiliation = $affiliation;
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
     * @return static
     */
    public function setAward($award)
    {
        $this->_award = $award;
        return $this;
    }

    private $_birthDate;

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->_birthDate;
    }

    /**
     * Date of birth.
     *
     * @param DateValue $birthDate
     * @return static
     */
    public function setBirthDate(DateValue $birthDate)
    {
        $this->_birthDate = $birthDate->getValue();
        return $this;
    }

    private $_birthPlace;

    /**
     * @return Place
     */
    public function getBirthPlace()
    {
        return $this->_birthPlace;
    }

    /**
     * The place where the person was born.
     *
     * @param Place $birthPlace
     * @return static
     */
    public function setBirthPlace($birthPlace)
    {
        $this->_birthPlace = $birthPlace;
        return $this;
    }

    private $_brand;

    /**
     * @return Brand|Organization
     */
    public function getBrand()
    {
        return $this->_brand;
    }

    /**
     * The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     *
     * @param Brand|Organization $brand
     * @return static
     */
    public function setBrand($brand)
    {
        $this->_brand = $brand;
        return $this;
    }

    private $_children;

    /**
     * @return Person
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * A child of the person.
     *
     * @param Person $children
     * @return static
     */
    public function setChildren(Person $children)
    {
        $this->_children = $children;
        return $this;
    }

    private $_colleague;

    /**
     * @return Person
     */
    public function getColleague()
    {
        return $this->_colleague;
    }

    /**
     * A colleague of the person.
     *
     * Supersedes colleagues.
     *
     * @param Person $colleague
     * @return static
     */
    public function setColleague(Person $colleague)
    {
        $this->_colleague = $colleague;
        return $this;
    }

    private $_contactPoint;

    /**
     * @return ContactPoint
     */
    public function getContactPoint()
    {
        return $this->_contactPoint;
    }

    /**
     * A contact point for a person or organization.
     *
     * Supersedes contactPoints.
     *
     * @param ContactPoint $contactPoint
     * @return static
     */
    public function setContactPoint(ContactPoint $contactPoint)
    {
        $this->_contactPoint = $contactPoint;
        return $this;
    }

    private $_deathDate;

    /**
     * @return string
     */
    public function getDeathDate()
    {
        return $this->_deathDate;
    }

    /**
     * Date of death.
     *
     * @param DateValue $deathDate
     * @return static
     */
    public function setDeathDate(DateValue $deathDate)
    {
        $this->_deathDate = $deathDate->getValue();
        return $this;
    }

    private $_deathPlace;

    /**
     * @return Place
     */
    public function getDeathPlace()
    {
        return $this->_deathPlace;
    }

    /**
     * The place where the person died.
     *
     * @param Place $deathPlace
     * @return static
     */
    public function setDeathPlace(Place $deathPlace)
    {
        $this->_deathPlace = $deathPlace;
        return $this;
    }

    private $_duns;

    /**
     * @return string
     */
    public function getDuns()
    {
        return $this->_duns;
    }

    /**
     * The Dun & Bradstreet DUNS number for identifying an organization or business person.
     *
     * @param string $duns
     * @return static
     */
    public function setDuns(Person $duns)
    {
        $this->_duns = $duns;
        return $this;
    }

    private $_email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Email address.
     *
     * @param string $email
     * @return static
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    private $_familyName;

    /**
     * @return string
     */
    public function getFamilyName()
    {
        return $this->_familyName;
    }

    /**
     * Family name. In the U.S., the last name of an Person.
     * This can be used along with givenName instead of the name property.
     *
     * @param string $familyName
     * @return static
     */
    public function setFamilyName($familyName)
    {
        $this->_familyName = $familyName;
        return $this;
    }

    private $_faxNumber;

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }

    /**
     * The fax number.
     *
     * @param string $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber = $faxNumber;
        return $this;
    }

    private $_follows;

    /**
     * @return Person
     */
    public function getFollows()
    {
        return $this->_follows;
    }

    /**
     * The most generic uni-directional social relation.
     *
     * @param Person $follows
     * @return static
     */
    public function setFollows(Person $follows)
    {
        $this->_follows = $follows;
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

    private $_gender;

    /**
     * @return GenderType|string
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used,
     * text strings are also acceptable for people who do not identify as a binary gender.
     *
     * @param GenderType|string $gender
     * @return static
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
        return $this;
    }

    private $_givenName;

    /**
     * @return string
     */
    public function getGivenName()
    {
        return $this->_givenName;
    }

    /**
     * Given name. In the U.S., the first name of a Person.
     * This can be used along with familyName instead of the name property.
     *
     * @param string $givenName
     * @return static
     */
    public function setGivenName($givenName)
    {
        $this->_givenName = $givenName;
        return $this;
    }

    private $_globalLocationNumber;

    /**
     * @return string
     */
    public function getGlobalLocationNumber()
    {
        return $this->_globalLocationNumber;
    }

    /**
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place.
     * The GLN is a 13-digit number used to identify parties and physical locations.
     *
     * @param string $globalLocationNumber
     * @return static
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->_globalLocationNumber = $globalLocationNumber;
        return $this;
    }

    private $_hasPOS;

    /**
     * @return Place
     */
    public function getHasPOS()
    {
        return $this->_hasPOS;
    }

    /**
     * Points-of-Sales operated by the organization or person.
     *
     * @param Place $hasPOS
     * @return static
     */
    public function setHasPOS($hasPOS)
    {
        $this->_hasPOS = $hasPOS;
        return $this;
    }

    private $_height;

    /**
     * @return Distance|QuantitativeValue
     */
    public function getHeight()
    {
        return $this->_height;
    }

    /**
     * The height of the item.
     *
     * @param Distance|QuantitativeValue $height
     * @return static
     */
    public function setHeight($height)
    {
        $this->_height = $height;
        return $this;
    }

    private $_homeLocation;

    /**
     * @return ContactPoint|Place
     */
    public function getHomeLocation()
    {
        return $this->_homeLocation;
    }

    /**
     * A contact location for a person's residence.
     *
     * @param ContactPoint|Place $homeLocation
     * @return static
     */
    public function setHomeLocation($homeLocation)
    {
        $this->_homeLocation = $homeLocation;
        return $this;
    }

    private $_honorificPrefix;

    /**
     * @return string
     */
    public function getHonorificPrefix()
    {
        return $this->_honorificPrefix;
    }

    /**
     * An honorific prefix preceding a Person's name such as Dr/Mrs/Mr.
     *
     * @param string $honorificPrefix
     * @return static
     */
    public function setHonorificPrefix($honorificPrefix)
    {
        $this->_honorificPrefix = $honorificPrefix;
        return $this;
    }

    private $_honorificSuffix;

    /**
     * @return string
     */
    public function getHonorificSuffix()
    {
        return $this->_honorificSuffix;
    }

    /**
     * An honorific suffix preceding a Person's name such as M.D. /PhD/MSCSW.
     *
     * @param string $honorificSuffix
     * @return static
     */
    public function setHonorificSuffix($honorificSuffix)
    {
        $this->_honorificSuffix = $honorificSuffix;
        return $this;
    }

    private $_isicV4;

    /**
     * @return string
     */
    public function getIsicV4()
    {
        return $this->_isicV4;
    }

    /**
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @param string $isicV4
     * @return static
     */
    public function setIsicV4($isicV4)
    {
        $this->_isicV4 = $isicV4;
        return $this;
    }

    private $_jobTitle;

    /**
     * @return string
     */
    public function getJobTitle()
    {
        return $this->_jobTitle;
    }

    /**
     * The job title of the person (for example, Financial Manager).
     *
     * @param string $jobTitle
     * @return static
     */
    public function setJobTitle($jobTitle)
    {
        $this->_jobTitle = $jobTitle;
        return $this;
    }

    private $_knows;

    /**
     * @return Person
     */
    public function getKnows()
    {
        return $this->_knows;
    }

    /**
     * The most generic bi-directional social/work relation.
     *
     * @param Person $knows
     * @return static
     */
    public function setKnows(Person $knows)
    {
        $this->_knows = $knows;
        return $this;
    }

    private $_makesOffer;

    /**
     * @return Offer
     */
    public function getMakesOffer()
    {
        return $this->_makesOffer;
    }

    /**
     * A pointer to products or services offered by the organization or person.
     * Inverse property: offeredBy.
     *
     * @param Offer $makesOffer
     * @return static
     */
    public function setMakesOffer(Offer $makesOffer)
    {
        $this->_makesOffer = $makesOffer;
        return $this;
    }

    private $_memberOf;

    /**
     * @return Organization|ProgramMembership
     */
    public function getMemberOf()
    {
        return $this->_memberOf;
    }

    /**
     * An Organization (or ProgramMembership) to which this Person or Organization belongs.
     * Inverse property: member.
     *
     * @param Organization|ProgramMembership $memberOf
     * @return static
     */
    public function setMemberOf($memberOf)
    {
        $this->_memberOf = $memberOf;
        return $this;
    }

    private $_naics;

    /**
     * @return string
     */
    public function getNaics()
    {
        return $this->_naics;
    }

    /**
     * The North American Industry Classification System (NAICS) code for a particular organization or business person.
     *
     * @param string $naics
     * @return static
     */
    public function setNaics($naics)
    {
        $this->_naics = $naics;
        return $this;
    }

    private $_nationality;

    /**
     * @return Country
     */
    public function getNationality()
    {
        return $this->_nationality;
    }

    /**
     * Nationality of the person.
     *
     * @param Country $nationality
     * @return static
     */
    public function setNationality(Country $nationality)
    {
        $this->_nationality = $nationality;
        return $this;
    }

    private $_parent;

    /**
     * @return Person
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * A parent of this person. Supersedes parents.
     *
     * @param Person $parent
     * @return static
     */
    public function setParent(Person $parent)
    {
        $this->_parent = $parent;
        return $this;
    }

    private $_performerIn;

    /**
     * @return Event
     */
    public function getPerformerIn()
    {
        return $this->_performerIn;
    }

    /**
     * Event that this person is a performer or participant in.
     *
     * @param Event $performerIn
     * @return static
     */
    public function setPerformerIn(Event $performerIn)
    {
        $this->_performerIn = $performerIn;
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
     * @return static
     */
    public function setPublishingPrinciples($publishingPrinciples)
    {
        $this->_publishingPrinciples = $publishingPrinciples;
        return $this;
    }

    private $_relatedTo;

    /**
     * @return Person
     */
    public function getRelatedTo()
    {
        return $this->_relatedTo;
    }

    /**
     * The most generic familial relation.
     *
     * @param Person $relatedTo
     * @return static
     */
    public function setRelatedTo(Person $relatedTo)
    {
        $this->_relatedTo = $relatedTo;
        return $this;
    }

    private $_sibling;

    /**
     * @return Person
     */
    public function getSibling()
    {
        return $this->_sibling;
    }

    /**
     * A sibling of the person. Supersedes siblings.
     *
     * @param Person $sibling
     * @return static
     */
    public function setSibling(Person $sibling)
    {
        $this->_sibling = $sibling;
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

    private $_spouse;

    /**
     * @return Person
     */
    public function getSpouse()
    {
        return $this->_spouse;
    }

    /**
     * The person's spouse.
     *
     * @param Person $spouse
     * @return static
     */
    public function setSpouse(Person $spouse)
    {
        $this->_spouse = $spouse;
        return $this;
    }

    private $_taxID;

    /**
     * @return string
     */
    public function getTaxID()
    {
        return $this->_taxID;
    }

    /**
     * The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     *
     * @param string $taxID
     * @return static
     */
    public function setTaxID($taxID)
    {
        $this->_taxID = $taxID;
        return $this;
    }

    private $_telephone;

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * The telephone number.
     *
     * @param string $telephone
     * @return static
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        return $this;
    }

    private $_vatID;

    /**
     * @return string
     */
    public function getVatID()
    {
        return $this->_vatID;
    }

    /**
     * The Value-added Tax ID of the organization or person.
     *
     * @param string $vatID
     * @return static
     */
    public function setVatID($vatID)
    {
        $this->_vatID = $vatID;
        return $this;
    }

    private $_workLocation;

    /**
     * @return ContactPoint|Place
     */
    public function getWorkLocation()
    {
        return $this->_workLocation;
    }

    /**
     * A contact location for a person's place of work.
     *
     * @param ContactPoint|Place $workLocation
     * @return static
     */
    public function setWorkLocation($workLocation)
    {
        $this->_workLocation = $workLocation;
        return $this;
    }

    private $_worksFor;

    /**
     * @return Organization
     */
    public function getWorksFor()
    {
        return $this->_worksFor;
    }

    /**
     * Organizations that the person works for.
     *
     * @param Organization $worksFor
     * @return static
     */
    public function setWorksFor(Organization $worksFor)
    {
        $this->_worksFor = $worksFor;
        return $this;
    }
}
