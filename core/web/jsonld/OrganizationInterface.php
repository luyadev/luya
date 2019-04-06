<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Organization interface
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
interface OrganizationInterface
{
    /**
     * @return mixed
     */
    public function getActionableFeedbackPolicy();

    /**
     * @param mixed $actionableFeedbackPolicy
     * @return static
     */
    public function setActionableFeedbackPolicy($actionableFeedbackPolicy);

    /**
     * @return mixed
     */
    public function getAddress();

    /**
     * @param mixePostalAddressd $address
     * @return static
     */
    public function setAddress(PostalAddress $address);

    /**
     * @return mixed
     */
    public function getAggregateRating();

    /**
     * @param AggregateRating $aggregateRating
     * @return static
     */
    public function setAggregateRating(AggregateRating $aggregateRating);

    /**
     * @return mixed
     */
    public function getAlumni();

    /**
     * @param mixed $alumni
     * @return static
     */
    public function setAlumni($alumni);

    /**
     * @return mixed
     */
    public function getAreaServed();

    /**
     * @param mixed $areaServed
     * @return static
     */
    public function setAreaServed($areaServed);

    /**
     * @return mixed
     */
    public function getAward();

    /**
     * @param mixed $award
     * @return static
     */
    public function setAward($award);

    /**
     * @return mixed
     */
    public function getBrand();

    /**
     * @param mixed $brand
     * @return static
     */
    public function setBrand($brand);

    /**
     * @return mixed
     */
    public function getContactPoint();

    /**
     * @param mixed $contactPoint
     * @return static
     */
    public function setContactPoint($contactPoint);

    /**
     * @return mixed
     */
    public function getCorrectionsPolicy();

    /**
     * @param mixed $correctionsPolicy
     * @return static
     */
    public function setCorrectionsPolicy($correctionsPolicy);

    /**
     * @return mixed
     */
    public function getDepartment();

    /**
     * @param mixed $department
     * @return static
     */
    public function setDepartment($department);

    /**
     * @return mixed
     */
    public function getDissolutionDate();

    /**
     * @param mixed $dissolutionDate
     * @return static
     */
    public function setDissolutionDate($dissolutionDate);

    /**
     * @return mixed
     */
    public function getDiversityPolicy();

    /**
     * @param mixed $diversityPolicy
     * @return static
     */
    public function setDiversityPolicy($diversityPolicy);

    /**
     * @return mixed
     */
    public function getDuns();

    /**
     * @param mixed $duns
     * @return static
     */
    public function setDuns($duns);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $email
     * @return static
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getEmployee();

    /**
     * @param mixed $employee
     * @return static
     */
    public function setEmployee($employee);

    /**
     * @return mixed
     */
    public function getEthicsPolicy();

    /**
     * @param mixed $ethicsPolicy
     * @return static
     */
    public function setEthicsPolicy($ethicsPolicy);

    /**
     * @return mixed
     */
    public function getEvent();

    /**
     * @param Event $event
     * @return static
     */
    public function setEvent(Event $event);

    /**
     * @return mixed
     */
    public function getFaxNumber();

    /**
     * @param mixed $faxNumber
     * @return static
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return mixed
     */
    public function getFounder();

    /**
     * @param mixed $founder
     * @return static
     */
    public function setFounder($founder);

    /**
     * @return mixed
     */
    public function getFoundingDate();

    /**
     * @param mixed $foundingDate
     * @return static
     */
    public function setFoundingDate($foundingDate);

    /**
     * @return mixed
     */
    public function getFoundingLocation();

    /**
     * @param mixed $foundingLocation
     * @return static
     */
    public function setFoundingLocation($foundingLocation);

    /**
     * @return mixed
     */
    public function getFunder();

    /**
     * @param mixed $funder
     * @return static
     */
    public function setFunder($funder);

    /**
     * @return mixed
     */
    public function getGlobalLocationNumber();

    /**
     * @param mixed $globalLocationNumber
     * @return static
     */
    public function setGlobalLocationNumber($globalLocationNumber);

    /**
     * @return mixed
     */
    public function getHasOfferCatalog();

    /**
     * @param mixed $hasOfferCatalog
     * @return static
     */
    public function setHasOfferCatalog($hasOfferCatalog);

    /**
     * @return mixed
     */
    public function getHasPOS();

    /**
     * @param mixed $hasPOS
     * @return static
     */
    public function setHasPOS($hasPOS);

    /**
     * @return mixed
     */
    public function getIsicV4();

    /**
     * @param mixed $isicV4
     * @return static
     */
    public function setIsicV4($isicV4);

    /**
     * @return mixed
     */
    public function getLegalName();

    /**
     * @param mixed $legalName
     * @return static
     */
    public function setLegalName($legalName);

    /**
     * @return mixed
     */
    public function getLeiCode();

    /**
     * @param mixed $leiCode
     * @return static
     */
    public function setLeiCode($leiCode);

    /**
     * @return mixed
     */
    public function getLocation();

    /**
     * @param mixed $location
     * @return static
     */
    public function setLocation($location);

    /**
     * @return mixed
     */
    public function getLogo();

    /**
     * @param mixed $logo
     * @return static
     */
    public function setLogo(ImageObject $logo);

    /**
     * @return mixed
     */
    public function getMakesOffer();

    /**
     * @param mixed $makesOffer
     * @return static
     */
    public function setMakesOffer($makesOffer);

    /**
     * @return mixed
     */
    public function getMember();

    /**
     * @param mixed $member
     * @return static
     */
    public function setMember($member);

    /**
     * @return mixed
     */
    public function getMemberOf();

    /**
     * @param mixed $memberOf
     * @return static
     */
    public function setMemberOf($memberOf);

    /**
     * @return mixed
     */
    public function getNaics();

    /**
     * @param mixed $naics
     * @return static
     */
    public function setNaics($naics);

    /**
     * @return mixed
     */
    public function getNumberOfEmployees();

    /**
     * @param mixed $numberOfEmployees
     * @return static
     */
    public function setNumberOfEmployees($numberOfEmployees);

    /**
     * @return mixed
     */
    public function getOwns();

    /**
     * @param mixed $owns
     * @return static
     */
    public function setOwns($owns);

    /**
     * @return mixed
     */
    public function getParentOrganization();

    /**
     * @param mixed $parentOrganization
     * @return static
     */
    public function setParentOrganization($parentOrganization);

    /**
     * @return mixed
     */
    public function getPublishingPrinciples();

    /**
     * @param mixed $publishingPrinciples
     * @return static
     */
    public function setPublishingPrinciples($publishingPrinciples);

    /**
     * @return Review
     */
    public function getReview();

    /**
     * @param Review $review
     * @return static
     */
    public function setReview(Review $review);

    /**
     * @return mixed
     */
    public function getSeeks();

    /**
     * @param mixed $seeks
     * @return static
     */
    public function setSeeks($seeks);

    /**
     * @return mixed
     */
    public function getSponsor();

    /**
     * @param mixed $sponsor
     * @return static
     */
    public function setSponsor($sponsor);

    /**
     * @return mixed
     */
    public function getSubOrganization();

    /**
     * @param mixed $subOrganization
     * @return static
     */
    public function setSubOrganization($subOrganization);

    /**
     * @return mixed
     */
    public function getTaxID();

    /**
     * @param mixed $taxID
     * @return static
     */
    public function setTaxID($taxID);

    /**
     * @return mixed
     */
    public function getTelephone();

    /**
     * @param mixed $telephone
     * @return static
     */
    public function setTelephone($telephone);

    /**
     * @return mixed
     */
    public function getUnnamedSourcesPolicy();

    /**
     * @param mixed $unnamedSourcesPolicy
     * @return static
     */
    public function setUnnamedSourcesPolicy($unnamedSourcesPolicy);

    /**
     * @return mixed
     */
    public function getVatID();

    /**
     * @param mixed $vatID
     * @return static
     */
    public function setVatID($vatID);
}
