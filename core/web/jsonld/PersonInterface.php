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
     * @return static
     */
    public function setAdditionalName($additionalName);

    /**
     * @return PostalAddress
     */
    public function getAddress();

    /**
     * @param PostalAddress $address
     * @return static
     */
    public function setAddress(PostalAddress $address);

    /**
     * @return Organization
     */
    public function getAffiliation();

    /**
     * @param Organization $affiliation
     * @return static
     */
    public function setAffiliation(Organization $affiliation);

    /**
     * @return string
     */
    public function getAward();

    /**
     * @param $award
     * @return static
     */
    public function setAward($award);

    /**
     * @return string
     */
    public function getBirthDate();

    /**
     * @param DateValue $birthDate
     * @return static
     */
    public function setBirthDate(DateValue $birthDate);

    /**
     * @return Place
     */
    public function getBirthPlace();

    /**
     * @param Place $birthPlace
     * @return static
     */
    public function setBirthPlace($birthPlace);

    /**
     * @return Brand|Organization
     */
    public function getBrand();

    /**
     * @param Brand|Organization $brand
     * @return static
     */
    public function setBrand($brand);
    /**
     * @return Person
     */
    public function getChildren();

    /**
     * @param Person $children
     * @return static
     */
    public function setChildren(Person $children);

    /**
     * @return Person
     */
    public function getColleague();

    /**
     * @param Person $colleague
     * @return static
     */
    public function setColleague(Person $colleague);

    /**
     * @return ContactPoint
     */
    public function getContactPoint();

    /**
     * @param ContactPoint $contactPoint
     * @return static
     */
    public function setContactPoint(ContactPoint $contactPoint);

    /**
     * @return DateValue
     */
    public function getDeathDate();

    /**
     * @param DateValue $deathDate
     * @return static
     */
    public function setDeathDate(DateValue $deathDate);

    /**
     * @return Place
     */
    public function getDeathPlace();

    /**
     * @param Place $deathPlace
     * @return static
     */
    public function setDeathPlace(Place $deathPlace);

    /**
     * @return string
     */
    public function getDuns();

    /**
     * @param $duns
     * @return static
     */
    public function setDuns(Person $duns);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param $email
     * @return static
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getFamilyName();

    /**
     * @param $familyName
     * @return static
     */
    public function setFamilyName($familyName);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return Person
     */
    public function getFollows();

    /**
     * @param Person $follows
     * @return static
     */
    public function setFollows(Person $follows);

    /**
     * @return Organization|Person
     */
    public function getFunder();

    /**
     * @param Organization|Person $funder
     * @return static
     */
    public function setFunder($funder);

    /**
     * @return GenderType|string
     */
    public function getGender();

    /**
     * @param GenderType|$gender
     * @return static
     */
    public function setGender($gender);

    /**
     * @return string
     */
    public function getGivenName();

    /**
     * @param $givenName
     * @return static
     */
    public function setGivenName($givenName);

    /**
     * @return string
     */
    public function getGlobalLocationNumber();

    /**
     * @param $globalLocationNumber
     * @return static
     */
    public function setGlobalLocationNumber($globalLocationNumber);


    /**
     * @return Place
     */
    public function getHasPOS();

    /**
     * @param Place $hasPOS
     * @return static
     */
    public function setHasPOS($hasPOS);

    /**
     * @return Distance|QuantitativeValue
     */
    public function getHeight();
    /**
     * @param Distance|QuantitativeValue $height
     * @return static
     */
    public function setHeight($height);

    /**
     * @return ContactPoint|Place
     */
    public function getHomeLocation();

    /**
     * @param ContactPoint|Place $homeLocation
     * @return static
     */
    public function setHomeLocation($homeLocation);

    /**
     * @return string
     */
    public function getHonorificPrefix();

    /**
     * @param $honorificPrefix
     * @return static
     */
    public function setHonorificPrefix($honorificPrefix);

    /**
     * @return string
     */
    public function getHonorificSuffix();

    /**
     * @param $honorificSuffix
     * @return static
     */
    public function setHonorificSuffix($honorificSuffix);

    /**
     * @return string
     */
    public function getIsicV4();

    /**
     * @param $isicV4
     * @return static
     */
    public function setIsicV4($isicV4);
    /**
     * @return string
     */
    public function getJobTitle();
    /**
     * @param $jobTitle
     * @return static
     */
    public function setJobTitle($jobTitle);

    /**
     * @return Person
     */
    public function getKnows();
    /**
     * @param Person $knows
     * @return static
     */
    public function setKnows(Person $knows);
    
    /**
     * @return Offer
     */
    public function getMakesOffer();

    /**
     * @param Offer $makesOffer
     * @return static
     */
    public function setMakesOffer(Offer $makesOffer);

    /**
     * @return Organization|ProgramMembership
     */
    public function getMemberOf();

    /**
     * @param Organization|ProgramMembership $memberOf
     * @return static
     */
    public function setMemberOf($memberOf);

    /**
     * @return string
     */
    public function getNaics();

    /**
     * @param $naics
     * @return static
     */
    public function setNaics($naics);

    /**
     * @return Country
     */
    public function getNationality();
    /**
     * @param Country $nationality
     * @return static
     */
    public function setNationality(Country $nationality);
    /**
     * @return Person
     */
    public function getParent();

    /**
     * @param Person $parent
     * @return static
     */
    public function setParent(Person $parent);

    /**
     * @return Event
     */
    public function getPerformerIn();
    /**
     * @param Event $performerIn
     * @return static
     */
    public function setPerformerIn(Event $performerIn);

    /**
     * @return CreativeWork|URL
     */
    public function getPublishingPrinciples();

    /**
     * @param CreativeWork|URL $publishingPrinciples
     * @return static
     */
    public function setPublishingPrinciples($publishingPrinciples);

    /**
     * @return Person
     */
    public function getRelatedTo();

    /**
     * @param Person $relatedTo
     * @return static
     */
    public function setRelatedTo(Person $relatedTo);


    /**
     * @return Person
     */
    public function getSibling();

    /**
     * @param Person $sibling
     * @return static
     */
    public function setSibling(Person $sibling);

    /**
     * @return Organization|Person
     */
    public function getSponsor();

    /**
     * @param Organization|Person $sponsor
     * @return static
     */
    public function setSponsor($sponsor);

    /**
     * @return Person
     */
    public function getSpouse();

    /**
     * @param Person $spouse
     * @return static
     */
    public function setSpouse(Person $spouse);

    /**
     * @return string
     */
    public function getTaxID();

    /**
     * @param $taxID
     * @return static
     */
    public function setTaxID($taxID);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param $telephone
     * @return static
     */
    public function setTelephone($telephone);

    /**
     * @return string
     */
    public function getVatID();

    /**
     * @param $vatID
     * @return static
     */
    public function setVatID($vatID);

    /**
     * @return ContactPoint|Place
     */
    public function getWorkLocation();

    /**
     * @param ContactPoint|Place $workLocation
     * @return static
     */
    public function setWorkLocation($workLocation);

    /**
     * @return Organization
     */
    public function getWorksFor();

    /**
     * @param Organization $worksFor
     * @return static
     */
    public function setWorksFor(Organization $worksFor);
}
