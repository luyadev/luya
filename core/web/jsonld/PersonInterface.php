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
     * @param $additionalName
     * @return PersonTrait
     */
    public function setAdditionalName($additionalName);

    /**
     * @return PostalAddress
     */
    public function getAddress();

    /**
     * @param PostalAddress $address
     * @return PersonTrait
     */
    public function setAddress(PostalAddress $address);

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
     * @return string
     */
    public function getAward();

    /**
     * @param $award
     * @return PersonTrait
     */
    public function setAward($award);

    /**
     * @return string
     */
    public function getBirthDate();

    /**
     * @param DateValue $birthDate
     * @return PersonTrait
     */
    public function setBirthDate(DateValue $birthDate);

    /**
     * @return Place
     */
    public function getBirthPlace();

    /**
     * @param Place $birthPlace
     * @return PersonTrait
     */
    public function setBirthPlace($birthPlace);

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
     * @return DateValue
     */
    public function getDeathDate();

    /**
     * @param DateValue $deathDate
     * @return PersonTrait
     */
    public function setDeathDate(DateValue $deathDate);

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
     * @param $duns
     * @return PersonTrait
     */
    public function setDuns(Person $duns);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param $email
     * @return PersonTrait
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getFamilyName();

    /**
     * @param $familyName
     * @return PersonTrait
     */
    public function setFamilyName($familyName);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param $faxNumber
     * @return PersonTrait
     */
    public function setFaxNumber($faxNumber);

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
     * @param GenderType|$gender
     * @return PersonTrait
     */
    public function setGender($gender);

    /**
     * @return string
     */
    public function getGivenName();

    /**
     * @param $givenName
     * @return PersonTrait
     */
    public function setGivenName($givenName);

    /**
     * @return string
     */
    public function getGlobalLocationNumber();

    /**
     * @param $globalLocationNumber
     * @return PersonTrait
     */
    public function setGlobalLocationNumber($globalLocationNumber);


    /**
     * @return Place
     */
    public function getHasPOS();

    /**
     * @param Place $hasPOS
     * @return PersonTrait
     */
    public function setHasPOS($hasPOS);

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
     * @param $honorificPrefix
     * @return PersonTrait
     */
    public function setHonorificPrefix($honorificPrefix);

    /**
     * @return string
     */
    public function getHonorificSuffix();

    /**
     * @param $honorificSuffix
     * @return PersonTrait
     */
    public function setHonorificSuffix($honorificSuffix);

    /**
     * @return string
     */
    public function getIsicV4();

    /**
     * @param $isicV4
     * @return PersonTrait
     */
    public function setIsicV4($isicV4);
    /**
     * @return string
     */
    public function getJobTitle();
    /**
     * @param $jobTitle
     * @return PersonTrait
     */
    public function setJobTitle($jobTitle);

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
     * @param $naics
     * @return PersonTrait
     */
    public function setNaics($naics);

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
     * @param $taxID
     * @return PersonTrait
     */
    public function setTaxID($taxID);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param $telephone
     * @return PersonTrait
     */
    public function setTelephone($telephone);

    /**
     * @return string
     */
    public function getVatID();

    /**
     * @param $vatID
     * @return PersonTrait
     */
    public function setVatID($vatID);

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
}
