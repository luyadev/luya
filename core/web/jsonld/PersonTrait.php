<?php

namespace luya\web\jsonld;

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
    /**
     * 	An additional name for a Person, can be used for a middle name.
     *
     * @var string
     */
    private $_additionalName;

    /**
     * @return string
     */
    public function getAdditionalName()
    {
        return $this->_additionalName;
    }

    /**
     * @param string $additionalName
     * @return PersonTrait
     */
    public function setAdditionalName($additionalName)
    {
        $this->_additionalName = $additionalName;
        return $this;
    }

    /**
     * Physical address of the item.
     *
     * @var PostalAddress|string
     */
    private $_address;

    /**
     * @return PostalAddress|string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param PostalAddress|string $address
     * @return PersonTrait
     */
    public function setAddress($address)
    {
        $this->_address = $address;
        return $this;
    }

    /**
     * An organization that this person is affiliated with. For example, a school/university, a club, or a team.
     *
     * @var Organization
     */
    private $_affiliation;

    /**
     * @return Organization
     */
    public function getAffiliation()
    {
        return $this->_affiliation;
    }

    /**
     * @param Organization $affiliation
     * @return PersonTrait
     */
    public function setAffiliation(Organization $affiliation)
    {
        $this->_affiliation = $affiliation;
        return $this;
    }

    /**
     * An organization that the person is an alumni of.
     *
     * @var EducationalOrganization|Organization
     */
    private $_alumniOf;

    /**
     * @return EducationalOrganization|Organization
     */
    public function getAlumniOf()
    {
        return $this->_alumniOf;
    }

    /**
     * @param EducationalOrganization|Organization $alumniOf
     * @return PersonTrait
     */
    public function setAlumniOf($alumniOf)
    {
        $this->_alumniOf = $alumniOf;
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
     * @return PersonTrait
     */
    public function setAward($award)
    {
        $this->_award = $award;
        return $this;
    }

    /**
     * Date of birth.
     *
     * @var Date
     */
    private $_birthDate;

    /**
     * @return Date
     */
    public function getBirthDate()
    {
        return $this->_birthDate;
    }

    /**
     * @param Date $birthDate
     * @return PersonTrait
     */
    public function setBirthDate($birthDate)
    {
        $this->_birthDate = $birthDate;
        return $this;
    }

    /**
     * The place where the person was born.
     *
     * @var Place
     */
    private $_birthPlace;

    /**
     * @return Place
     */
    public function getBirthPlace()
    {
        return $this->_birthPlace;
    }

    /**
     * @param Place $birthPlace
     * @return PersonTrait
     */
    public function setBirthPlace($birthPlace)
    {
        $this->_birthPlace = $birthPlace;
        return $this;
    }

    /**
     * The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     *
     * @var Brand|Organization
     */
    private $_brand;

    /**
     * @return Brand|Organization
     */
    public function getBrand()
    {
        return $this->_brand;
    }

    /**
     * @param Brand|Organization $brand
     * @return PersonTrait
     */
    public function setBrand($brand)
    {
        $this->_brand = $brand;
        return $this;
    }

    /**
     * A child of the person.
     *
     * @var Person
     */
    private $_children;

    /**
     * @return Person
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * @param Person $children
     * @return PersonTrait
     */
    public function setChildren(Person $children)
    {
        $this->_children = $children;
        return $this;
    }

    /**
     * A colleague of the person.
     * Supersedes colleagues.
     *
     * @var Person
     */
    private $_colleague;

    /**
     * @return Person
     */
    public function getColleague()
    {
        return $this->_colleague;
    }

    /**
     * @param Person $colleague
     * @return PersonTrait
     */
    public function setColleague(Person $colleague)
    {
        $this->_colleague = $colleague;
        return $this;
    }

    /**
     * A contact point for a person or organization.
     * Supersedes contactPoints.
     *
     * @var ContactPoint
     */
    private $_contactPoint;

    /**
     * @return ContactPoint
     */
    public function getContactPoint()
    {
        return $this->_contactPoint;
    }

    /**
     * @param ContactPoint $contactPoint
     * @return PersonTrait
     */
    public function setContactPoint($contactPoint)
    {
        $this->_contactPoint = $contactPoint;
        return $this;
    }

    /**
     * Date of death.
     *
     * @var Date
     */
    private $_deathDate;

    /**
     * @return Date
     */
    public function getDeathDate()
    {
        return $this->_deathDate;
    }

    /**
     * @param Date $deathDate
     * @return PersonTrait
     */
    public function setDeathDate($deathDate)
    {
        $this->_deathDate = $deathDate;
        return $this;
    }

    /**
     * The place where the person died.
     *
     * @var Place
     */
    private $_deathPlace;

    /**
     * @return Place
     */
    public function getDeathPlace()
    {
        return $this->_deathPlace;
    }

    /**
     * @param Place $deathPlace
     * @return PersonTrait
     */
    public function setDeathPlace($deathPlace)
    {
        $this->_deathPlace = $deathPlace;
        return $this;
    }

    /**
     * The Dun & Bradstreet DUNS number for identifying an organization or business person.
     *
     * @var string
     */
    private $_duns;

    /**
     * @return string
     */
    public function getDuns()
    {
        return $this->_duns;
    }

    /**
     * @param string $duns
     * @return PersonTrait
     */
    public function setDuns($duns)
    {
        $this->_duns = $duns;
        return $this;
    }

    /**
     * Email address.
     *
     * @var string
     */
    private $_email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     * @return PersonTrait
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * Family name. In the U.S., the last name of an Person.
     * This can be used along with givenName instead of the name property.
     *
     * @var string
     */
    private $_familyName;

    /**
     * @return string
     */
    public function getFamilyName()
    {
        return $this->_familyName;
    }

    /**
     * @param string $familyName
     * @return PersonTrait
     */
    public function setFamilyName($familyName)
    {
        $this->_familyName = $familyName;
        return $this;
    }

    /**
     * The fax number.
     *
     * @var string
     */
    private $_faxNumber;

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }

    /**
     * @param string $faxNumber
     * @return PersonTrait
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber = $faxNumber;
        return $this;
    }

    /**
     * The most generic uni-directional social relation.
     *
     * @var Person
     */
    private $_follows;

    /**
     * @return Person
     */
    public function getFollows()
    {
        return $this->_follows;
    }

    /**
     * @param Person $follows
     * @return PersonTrait
     */
    public function setFollows(Person $follows)
    {
        $this->_follows = $follows;
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
     * @return PersonTrait
     */
    public function setFunder($funder)
    {
        $this->_funder = $funder;
        return $this;
    }

    /**
     * Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used,
     * text strings are also acceptable for people who do not identify as a binary gender.
     *
     * @var GenderType|string
     */
    private $_gender;

    /**
     * @return GenderType|string
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param GenderType|string $gender
     * @return PersonTrait
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
        return $this;
    }

    /**
     * Given name. In the U.S., the first name of a Person.
     * This can be used along with familyName instead of the name property.
     *
     * @var string
     */
    private $_givenName;

    /**
     * @return string
     */
    public function getGivenName()
    {
        return $this->_givenName;
    }

    /**
     * @param string $givenName
     * @return PersonTrait
     */
    public function setGivenName($givenName)
    {
        $this->_givenName = $givenName;
        return $this;
    }

    /**
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place.
     * The GLN is a 13-digit number used to identify parties and physical locations.
     *
     * @var string
     */
    private $_globalLocationNumber;

    /**
     * @return string
     */
    public function getGlobalLocationNumber()
    {
        return $this->_globalLocationNumber;
    }

    /**
     * @param string $globalLocationNumber
     * @return PersonTrait
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->_globalLocationNumber = $globalLocationNumber;
        return $this;
    }

    /**
     * The Person's occupation. For past professions, use Role for expressing dates.
     *
     * @var Occupation
     */
    private $_hasOccupation;

    /**
     * @return Occupation
     */
    public function getHasOccupation()
    {
        return $this->_hasOccupation;
    }

    /**
     * @param Occupation $hasOccupation
     * @return PersonTrait
     */
    public function setHasOccupation($hasOccupation)
    {
        $this->_hasOccupation = $hasOccupation;
        return $this;
    }

    /**
     * Indicates an OfferCatalog listing for this Organization, Person, or Service.
     *
     * @var OfferCatalog
     */
    private $_hasOfferCatalog;

    /**
     * @return OfferCatalog
     */
    public function getHasOfferCatalog()
    {
        return $this->_hasOfferCatalog;
    }

    /**
     * @param OfferCatalog $hasOfferCatalog
     * @return PersonTrait
     */
    public function setHasOfferCatalog($hasOfferCatalog)
    {
        $this->_hasOfferCatalog = $hasOfferCatalog;
        return $this;
    }

    /**
     * Points-of-Sales operated by the organization or person.
     *
     * @var Place
     */
    private $_hasPOS;

    /**
     * @return Place
     */
    public function getHasPOS()
    {
        return $this->_hasPOS;
    }

    /**
     * @param Place $hasPOS
     * @return PersonTrait
     */
    public function setHasPOS($hasPOS)
    {
        $this->_hasPOS = $hasPOS;
        return $this;
    }

    /**
     * The height of the item.
     *
     * @var Distance|QuantitativeValue
     */
    private $_height;

    /**
     * @return Distance|QuantitativeValue
     */
    public function getHeight()
    {
        return $this->_height;
    }

    /**
     * @param Distance|QuantitativeValue $height
     * @return PersonTrait
     */
    public function setHeight($height)
    {
        $this->_height = $height;
        return $this;
    }

    /**
     * A contact location for a person's residence.
     *
     * @var ContactPoint|Place
     */
    private $_homeLocation;

    /**
     * @return ContactPoint|Place
     */
    public function getHomeLocation()
    {
        return $this->_homeLocation;
    }

    /**
     * @param ContactPoint|Place $homeLocation
     * @return PersonTrait
     */
    public function setHomeLocation($homeLocation)
    {
        $this->_homeLocation = $homeLocation;
        return $this;
    }

    /**
     * An honorific prefix preceding a Person's name such as Dr/Mrs/Mr.
     *
     * @var string
     */
    private $_honorificPrefix;

    /**
     * @return string
     */
    public function getHonorificPrefix()
    {
        return $this->_honorificPrefix;
    }

    /**
     * @param string $honorificPrefix
     * @return PersonTrait
     */
    public function setHonorificPrefix($honorificPrefix)
    {
        $this->_honorificPrefix = $honorificPrefix;
        return $this;
    }

    /**
     * An honorific suffix preceding a Person's name such as M.D. /PhD/MSCSW.
     *
     * @var string
     */
    private $_honorificSuffix;

    /**
     * @return string
     */
    public function getHonorificSuffix()
    {
        return $this->_honorificSuffix;
    }

    /**
     * @param string $honorificSuffix
     * @return PersonTrait
     */
    public function setHonorificSuffix($honorificSuffix)
    {
        $this->_honorificSuffix = $honorificSuffix;
        return $this;
    }

    /**
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @var string
     */
    private $_isicV4;

    /**
     * @return string
     */
    public function getIsicV4()
    {
        return $this->_isicV4;
    }

    /**
     * @param string $isicV4
     * @return PersonTrait
     */
    public function setIsicV4($isicV4)
    {
        $this->_isicV4 = $isicV4;
        return $this;
    }

    /**
     * The job title of the person (for example, Financial Manager).
     *
     * @var string
     */
    private $_jobTitle;

    /**
     * @return string
     */
    public function getJobTitle()
    {
        return $this->_jobTitle;
    }

    /**
     * @param string $jobTitle
     * @return PersonTrait
     */
    public function setJobTitle($jobTitle)
    {
        $this->_jobTitle = $jobTitle;
        return $this;
    }

    /**
     * The most generic bi-directional social/work relation.
     *
     * @var Person
     */
    private $_knows;

    /**
     * @return Person
     */
    public function getKnows()
    {
        return $this->_knows;
    }

    /**
     * @param Person $knows
     * @return PersonTrait
     */
    public function setKnows(Person $knows)
    {
        $this->_knows = $knows;
        return $this;
    }

    /**
     * A pointer to products or services offered by the organization or person.
     * Inverse property: offeredBy.
     *
     * @var Offer
     */
    private $_makesOffer;

    /**
     * @return Offer
     */
    public function getMakesOffer()
    {
        return $this->_makesOffer;
    }

    /**
     * @param Offer $makesOffer
     * @return PersonTrait
     */
    public function setMakesOffer($makesOffer)
    {
        $this->_makesOffer = $makesOffer;
        return $this;
    }

    /**
     * An Organization (or ProgramMembership) to which this Person or Organization belongs.
     * Inverse property: member.
     *
     * @var Organization|ProgramMembership
     */
    private $_memberOf;

    /**
     * @return Organization|ProgramMembership
     */
    public function getMemberOf()
    {
        return $this->_memberOf;
    }

    /**
     * @param Organization|ProgramMembership $memberOf
     * @return PersonTrait
     */
    public function setMemberOf($memberOf)
    {
        $this->_memberOf = $memberOf;
        return $this;
    }

    /**
     * The North American Industry Classification System (NAICS) code for a particular organization or business person.
     *
     * @var string
     */
    private $_naics;

    /**
     * @return string
     */
    public function getNaics()
    {
        return $this->_naics;
    }

    /**
     * @param string $naics
     * @return PersonTrait
     */
    public function setNaics($naics)
    {
        $this->_naics = $naics;
        return $this;
    }

    /**
     * Nationality of the person.
     *
     * @var Country
     */
    private $_nationality;

    /**
     * @return Country
     */
    public function getNationality()
    {
        return $this->_nationality;
    }

    /**
     * @param Country $nationality
     * @return PersonTrait
     */
    public function setNationality($nationality)
    {
        $this->_nationality = $nationality;
        return $this;
    }

    /**
     * The total financial value of the person as calculated by subtracting assets from liabilities.
     *
     * @var MonetaryAmount|PriceSpecification
     */
    private $_netWorth;

    /**
     * @return MonetaryAmount|PriceSpecification
     */
    public function getNetWorth()
    {
        return $this->_netWorth;
    }

    /**
     * @param MonetaryAmount|PriceSpecification $netWorth
     * @return PersonTrait
     */
    public function setNetWorth($netWorth)
    {
        $this->_netWorth = $netWorth;
        return $this;
    }

    /**
     * Products owned by the organization or person.
     *
     * @var OwnershipInfo|Product
     */
    private $_owns;

    /**
     * @return OwnershipInfo|Product
     */
    public function getOwns()
    {
        return $this->_owns;
    }

    /**
     * @param OwnershipInfo|Product $owns
     * @return PersonTrait
     */
    public function setOwns($owns)
    {
        $this->_owns = $owns;
        return $this;
    }

    /**
     * A parent of this person. Supersedes parents.
     *
     * @var Person
     */
    private $_parent;

    /**
     * @return Person
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * @param Person $parent
     * @return PersonTrait
     */
    public function setParent(Person $parent)
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * Event that this person is a performer or participant in.
     *
     * @var Event
     */
    private $_performerIn;

    /**
     * @return Event
     */
    public function getPerformerIn()
    {
        return $this->_performerIn;
    }

    /**
     * @param Event $performerIn
     * @return PersonTrait
     */
    public function setPerformerIn(Event $performerIn)
    {
        $this->_performerIn = $performerIn;
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
     * @return PersonTrait
     */
    public function setPublishingPrinciples($publishingPrinciples)
    {
        $this->_publishingPrinciples = $publishingPrinciples;
        return $this;
    }

    /**
     * The most generic familial relation.
     *
     * @var Person
     */
    private $_relatedTo;

    /**
     * @return Person
     */
    public function getRelatedTo()
    {
        return $this->_relatedTo;
    }

    /**
     * @param Person $relatedTo
     * @return PersonTrait
     */
    public function setRelatedTo(Person $relatedTo)
    {
        $this->_relatedTo = $relatedTo;
        return $this;
    }

    /**
     * A pointer to products or services sought by the organization or person (demand).
     *
     * @var Demand
     */
    private $_seeks;

    /**
     * @return Demand
     */
    public function getSeeks()
    {
        return $this->_seeks;
    }

    /**
     * @param Demand $seeks
     * @return PersonTrait
     */
    public function setSeeks($seeks)
    {
        $this->_seeks = $seeks;
        return $this;
    }

    /**
     * A sibling of the person. Supersedes siblings.
     *
     * @var Person
     */
    private $_sibling;

    /**
     * @return Person
     */
    public function getSibling()
    {
        return $this->_sibling;
    }

    /**
     * @param Person $sibling
     * @return PersonTrait
     */
    public function setSibling(Person $sibling)
    {
        $this->_sibling = $sibling;
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
     * @return PersonTrait
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor = $sponsor;
        return $this;
    }

    /**
     * The person's spouse.
     *
     * @var Person
     */
    private $_spouse;

    /**
     * @return Person
     */
    public function getSpouse()
    {
        return $this->_spouse;
    }

    /**
     * @param Person $spouse
     * @return PersonTrait
     */
    public function setSpouse(Person $spouse)
    {
        $this->_spouse = $spouse;
        return $this;
    }

    /**
     * The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     *
     * @var string
     */
    private $_taxID;

    /**
     * @return string
     */
    public function getTaxID()
    {
        return $this->_taxID;
    }

    /**
     * @param string $taxID
     * @return PersonTrait
     */
    public function setTaxID($taxID)
    {
        $this->_taxID = $taxID;
        return $this;
    }

    /**
     * The telephone number.
     *
     * @var string
     */
    private $_telephone;

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * @param string $telephone
     * @return PersonTrait
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;
        return $this;
    }

    /**
     * The Value-added Tax ID of the organization or person.
     *
     * @var string
     */
    private $_vatID;

    /**
     * @return string
     */
    public function getVatID()
    {
        return $this->_vatID;
    }

    /**
     * @param string $vatID
     * @return PersonTrait
     */
    public function setVatID($vatID)
    {
        $this->_vatID = $vatID;
        return $this;
    }

    /**
     * The weight of the product or person.
     *
     * @var QuantitativeValue
     */
    private $_weight;

    /**
     * @return QuantitativeValue
     */
    public function getWeight()
    {
        return $this->_weight;
    }

    /**
     * @param QuantitativeValue $weight
     * @return PersonTrait
     */
    public function setWeight($weight)
    {
        $this->_weight = $weight;
        return $this;
    }

    /**
     * A contact location for a person's place of work.
     *
     * @var ContactPoint|Place
     */
    private $_workLocation;

    /**
     * @return ContactPoint|Place
     */
    public function getWorkLocation()
    {
        return $this->_workLocation;
    }

    /**
     * @param ContactPoint|Place $workLocation
     * @return PersonTrait
     */
    public function setWorkLocation($workLocation)
    {
        $this->_workLocation = $workLocation;
        return $this;
    }

    /**
     * Organizations that the person works for.
     *
     * @var Organization
     */
    private $_worksFor;

    /**
     * @return Organization
     */
    public function getWorksFor()
    {
        return $this->_worksFor;
    }

    /**
     * @param Organization $worksFor
     * @return PersonTrait
     */
    public function setWorksFor(Organization $worksFor)
    {
        $this->_worksFor = $worksFor;
        return $this;
    }
}
