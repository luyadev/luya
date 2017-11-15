<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Person interface
 *
 * @see http://schema.org/Organization
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
interface PersonInterface
{
    /**
     * @return string
     */
    public function getAdditionalName();

    /**
     * @param string $additionalName
     * @return PersonTrait
     */
    public function setAdditionalName(string $additionalName);

    /**
     * @return PostalAddress|string
     */
    public function getAddress();

    /**
     * @param PostalAddress|string $address
     * @return PersonTrait
     */
    public function setAddress($address);

    /**
     * @return Organization
     */
    public function getAffiliation();

    /**
     * @param Organization $affiliation
     * @return PersonTrait
     */
    public function setAffiliation(Organization $affiliation);

    /**
     * @return EducationalOrganization|Organization
     */
    public function getAlumniOf();

    /**
     * @param EducationalOrganization|Organization $alumniOf
     * @return PersonTrait
     */
    public function setAlumniOf($alumniOf);

    /**
     * @return string
     */
    public function getAward();

    /**
     * @param string $award
     * @return PersonTrait
     */
    public function setAward(string $award);

    /**
     * @return Date
     */
    public function getBirthDate();

    /**
     * @param Date $birthDate
     * @return PersonTrait
     */
    public function setBirthDate(Date $birthDate);

    /**
     * @return Place
     */
    public function getBirthPlace();

    /**
     * @param Place $birthPlace
     * @return PersonTrait
     */
    public function setBirthPlace(Place $birthPlace);

    /**
     * @return Brand|Organization
     */
    public function getBrand();

    /**
     * @param Brand|Organization $brand
     * @return PersonTrait
     */
    public function setBrand($brand);
    /**
     * @return Person
     */
    public function getChildren();

    /**
     * @param Person $children
     * @return PersonTrait
     */
    public function setChildren(Person $children);

    /**
     * @return Person
     */
    public function getColleague();

    /**
     * @param Person $colleague
     * @return PersonTrait
     */
    public function setColleague(Person $colleague);

    /**
     * @return ContactPoint
     */
    public function getContactPoint();

    /**
     * @param ContactPoint $contactPoint
     * @return PersonTrait
     */
    public function setContactPoint(ContactPoint $contactPoint);

    /**
     * @return Date
     */
    public function getDeathDate();

    /**
     * @param Date $deathDate
     * @return PersonTrait
     */
    public function setDeathDate(Date $deathDate);

    /**
     * @return Place
     */
    public function getDeathPlace();

    /**
     * @param Place $deathPlace
     * @return PersonTrait
     */
    public function setDeathPlace(Place $deathPlace);

    /**
     * @return string
     */
    public function getDuns();

    /**
     * @param string $duns
     * @return PersonTrait
     */
    public function setDuns(string $duns);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return PersonTrait
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getFamilyName();

    /**
     * @param string $familyName
     * @return PersonTrait
     */
    public function setFamilyName(string $familyName);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param string $faxNumber
     * @return PersonTrait
     */
    public function setFaxNumber(string $faxNumber);

    /**
     * @return Person
     */
    public function getFollows();

    /**
     * @param Person $follows
     * @return PersonTrait
     */
    public function setFollows(Person $follows);

    /**
     * @return Organization|Person
     */
    public function getFunder();

    /**
     * @param Organization|Person $funder
     * @return PersonTrait
     */
    public function setFunder($funder);

    /**
     * @return GenderType|string
     */
    public function getGender();

    /**
     * @param GenderType|string $gender
     * @return PersonTrait
     */
    public function setGender($gender);

    /**
     * @return string
     */
    public function getGivenName();

    /**
     * @param string $givenName
     * @return PersonTrait
     */
    public function setGivenName(string $givenName);

    /**
     * @return string
     */
    public function getGlobalLocationNumber();

    /**
     * @param string $globalLocationNumber
     * @return PersonTrait
     */
    public function setGlobalLocationNumber(string $globalLocationNumber);

    /**
     * @return Occupation
     */
    public function getHasOccupation();

    /**
     * @param Occupation $hasOccupation
     * @return PersonTrait
     */
    public function setHasOccupation(Occupation $hasOccupation);

    /**
     * @return OfferCatalog
     */
    public function getHasOfferCatalog();

    /**
     * @param OfferCatalog $hasOfferCatalog
     * @return PersonTrait
     */
    public function setHasOfferCatalog(OfferCatalog $hasOfferCatalog);

    /**
     * @return Place
     */
    public function getHasPOS();

    /**
     * @param Place $hasPOS
     * @return PersonTrait
     */
    public function setHasPOS(Place $hasPOS);

    /**
     * @return Distance|QuantitativeValue
     */
    public function getHeight();
    /**
     * @param Distance|QuantitativeValue $height
     * @return PersonTrait
     */
    public function setHeight($height);

    /**
     * @return ContactPoint|Place
     */
    public function getHomeLocation();

    /**
     * @param ContactPoint|Place $homeLocation
     * @return PersonTrait
     */
    public function setHomeLocation($homeLocation);

    /**
     * @return string
     */
    public function getHonorificPrefix();

    /**
     * @param string $honorificPrefix
     * @return PersonTrait
     */
    public function setHonorificPrefix(string $honorificPrefix);

    /**
     * @return string
     */
    public function getHonorificSuffix();

    /**
     * @param string $honorificSuffix
     * @return PersonTrait
     */
    public function setHonorificSuffix(string $honorificSuffix);

    /**
     * @return string
     */
    public function getIsicV4();

    /**
     * @param string $isicV4
     * @return PersonTrait
     */
    public function setIsicV4(string $isicV4);
    /**
     * @return string
     */
    public function getJobTitle();
    /**
     * @param string $jobTitle
     * @return PersonTrait
     */
    public function setJobTitle(string $jobTitle);

    /**
     * @return Person
     */
    public function getKnows();
    /**
     * @param Person $knows
     * @return PersonTrait
     */
    public function setKnows(Person $knows);
    /**
     * @return Offer
     */
    public function getMakesOffer();

    /**
     * @param Offer $makesOffer
     * @return PersonTrait
     */
    public function setMakesOffer(Offer $makesOffer);

    /**
     * @return Organization|ProgramMembership
     */
    public function getMemberOf();

    /**
     * @param Organization|ProgramMembership $memberOf
     * @return PersonTrait
     */
    public function setMemberOf($memberOf);

    /**
     * @return string
     */
    public function getNaics();

    /**
     * @param string $naics
     * @return PersonTrait
     */
    public function setNaics(string $naics);

    /**
     * @return Country
     */
    public function getNationality();
    /**
     * @param Country $nationality
     * @return PersonTrait
     */
    public function setNationality(Country $nationality);
    /**
     * @return MonetaryAmount|PriceSpecification
     */
    public function getNetWorth();

    /**
     * @param MonetaryAmount|PriceSpecification $netWorth
     * @return PersonTrait
     */
    public function setNetWorth($netWorth);

    /**
     * @return OwnershipInfo|Product
     */
    public function getOwns();

    /**
     * @param OwnershipInfo|Product $owns
     * @return PersonTrait
     */
    public function setOwns($owns);

    /**
     * @return Person
     */
    public function getParent();

    /**
     * @param Person $parent
     * @return PersonTrait
     */
    public function setParent(Person $parent);

    /**
     * @return Event
     */
    public function getPerformerIn();
    /**
     * @param Event $performerIn
     * @return PersonTrait
     */
    public function setPerformerIn(Event $performerIn);

    /**
     * @return CreativeWork|URL
     */
    public function getPublishingPrinciples();

    /**
     * @param CreativeWork|URL $publishingPrinciples
     * @return PersonTrait
     */
    public function setPublishingPrinciples($publishingPrinciples);

    /**
     * @return Person
     */
    public function getRelatedTo();

    /**
     * @param Person $relatedTo
     * @return PersonTrait
     */
    public function setRelatedTo(Person $relatedTo);

    /**
     * @return Demand
     */
    public function getSeeks();

    /**
     * @param Demand $seeks
     * @return PersonTrait
     */
    public function setSeeks(Demand $seeks);

    /**
     * @return Person
     */
    public function getSibling();

    /**
     * @param Person $sibling
     * @return PersonTrait
     */
    public function setSibling(Person $sibling);

    /**
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return PersonTrait
     */
    public function setSponsor($sponsor);

    /**
     * @return Person
     */
    public function getSpouse();

    /**
     * @param Person $spouse
     * @return PersonTrait
     */
    public function setSpouse(Person $spouse);

    /**
     * @return string
     */
    public function getTaxID();

    /**
     * @param string $taxID
     * @return PersonTrait
     */
    public function setTaxID(string $taxID);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param string $telephone
     * @return PersonTrait
     */
    public function setTelephone(string $telephone);

    /**
     * @return string
     */
    public function getVatID();

    /**
     * @param string $vatID
     * @return PersonTrait
     */
    public function setVatID(string $vatID);

    /**
     * @return QuantitativeValue
     */
    public function getWeight();

    /**
     * @param QuantitativeValue $weight
     * @return PersonTrait
     */
    public function setWeight(QuantitativeValue $weight);

    /**
     * @return ContactPoint|Place
     */
    public function getWorkLocation();

    /**
     * @param ContactPoint|Place $workLocation
     * @return PersonTrait
     */
    public function setWorkLocation($workLocation);

    /**
     * @return Organization
     */
    public function getWorksFor();

    /**
     * @param Organization $worksFor
     * @return PersonTrait
     */
    public function setWorksFor(Organization $worksFor);

    /**
     * Return the fields
     */
    public function fields();
}