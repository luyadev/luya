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
     * @return Organization
     */
    public function setActionableFeedbackPolicy($actionableFeedbackPolicy);

    /**
     * @return mixed
     */
    public function getAddress();

    /**
     * @param mixed $address
     * @return Organization
     */
    public function setAddress($address);

    /**
     * @return mixed
     */
    public function getAggregateRating();

    /**
     * @param mixed $aggregateRating
     * @return Organization
     */
    public function setAggregateRating($aggregateRating);

    /**
     * @return mixed
     */
    public function getAlumni();

    /**
     * @param mixed $alumni
     * @return Organization
     */
    public function setAlumni($alumni);

    /**
     * @return mixed
     */
    public function getAreaServed();

    /**
     * @param mixed $areaServed
     * @return Organization
     */
    public function setAreaServed($areaServed);

    /**
     * @return mixed
     */
    public function getAward();

    /**
     * @param mixed $award
     * @return Organization
     */
    public function setAward($award);

    /**
     * @return mixed
     */
    public function getBrand();

    /**
     * @param mixed $brand
     * @return Organization
     */
    public function setBrand($brand);

    /**
     * @return mixed
     */
    public function getContactPoint();

    /**
     * @param mixed $contactPoint
     * @return Organization
     */
    public function setContactPoint($contactPoint);

    /**
     * @return mixed
     */
    public function getCorrectionsPolicy();

    /**
     * @param mixed $correctionsPolicy
     * @return Organization
     */
    public function setCorrectionsPolicy($correctionsPolicy);

    /**
     * @return mixed
     */
    public function getDepartment();

    /**
     * @param mixed $department
     * @return Organization
     */
    public function setDepartment($department);

    /**
     * @return mixed
     */
    public function getDissolutionDate();

    /**
     * @param mixed $dissolutionDate
     * @return Organization
     */
    public function setDissolutionDate($dissolutionDate);

    /**
     * @return mixed
     */
    public function getDiversityPolicy();

    /**
     * @param mixed $diversityPolicy
     * @return Organization
     */
    public function setDiversityPolicy($diversityPolicy);

    /**
     * @return mixed
     */
    public function getDuns();

    /**
     * @param mixed $duns
     * @return Organization
     */
    public function setDuns($duns);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $email
     * @return Organization
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getEmployee();

    /**
     * @param mixed $employee
     * @return Organization
     */
    public function setEmployee($employee);

    /**
     * @return mixed
     */
    public function getEthicsPolicy();

    /**
     * @param mixed $ethicsPolicy
     * @return Organization
     */
    public function setEthicsPolicy($ethicsPolicy);

    /**
     * @return mixed
     */
    public function getEvent();

    /**
     * @param mixed $event
     * @return Organization
     */
    public function setEvent($event);

    /**
     * @return mixed
     */
    public function getFaxNumber();

    /**
     * @param mixed $faxNumber
     * @return Organization
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return mixed
     */
    public function getFounder();

    /**
     * @param mixed $founder
     * @return Organization
     */
    public function setFounder($founder);

    /**
     * @return mixed
     */
    public function getFoundingDate();

    /**
     * @param mixed $foundingDate
     * @return Organization
     */
    public function setFoundingDate($foundingDate);

    /**
     * @return mixed
     */
    public function getFoundingLocation();

    /**
     * @param mixed $foundingLocation
     * @return Organization
     */
    public function setFoundingLocation($foundingLocation);

    /**
     * @return mixed
     */
    public function getFunder();

    /**
     * @param mixed $funder
     * @return Organization
     */
    public function setFunder($funder);

    /**
     * @return mixed
     */
    public function getGlobalLocationNumber();

    /**
     * @param mixed $globalLocationNumber
     * @return Organization
     */
    public function setGlobalLocationNumber($globalLocationNumber);

    /**
     * @return mixed
     */
    public function getHasOfferCatalog();

    /**
     * @param mixed $hasOfferCatalog
     * @return Organization
     */
    public function setHasOfferCatalog($hasOfferCatalog);

    /**
     * @return mixed
     */
    public function getHasPOS();

    /**
     * @param mixed $hasPOS
     * @return Organization
     */
    public function setHasPOS($hasPOS);

    /**
     * @return mixed
     */
    public function getIsicV4();

    /**
     * @param mixed $isicV4
     * @return Organization
     */
    public function setIsicV4($isicV4);

    /**
     * @return mixed
     */
    public function getLegalName();

    /**
     * @param mixed $legalName
     * @return Organization
     */
    public function setLegalName($legalName);

    /**
     * @return mixed
     */
    public function getLeiCode();

    /**
     * @param mixed $leiCode
     * @return Organization
     */
    public function setLeiCode($leiCode);

    /**
     * @return mixed
     */
    public function getLocation();

    /**
     * @param mixed $location
     * @return Organization
     */
    public function setLocation($location);

    /**
     * @return mixed
     */
    public function getLogo();

    /**
     * @param mixed $logo
     * @return Organization
     */
    public function setLogo(ImageObject $logo);

    /**
     * @return mixed
     */
    public function getMakesOffer();

    /**
     * @param mixed $makesOffer
     * @return Organization
     */
    public function setMakesOffer($makesOffer);

    /**
     * @return mixed
     */
    public function getMember();

    /**
     * @param mixed $member
     * @return Organization
     */
    public function setMember($member);

    /**
     * @return mixed
     */
    public function getMemberOf();

    /**
     * @param mixed $memberOf
     * @return Organization
     */
    public function setMemberOf($memberOf);

    /**
     * @return mixed
     */
    public function getNaics();

    /**
     * @param mixed $naics
     * @return Organization
     */
    public function setNaics($naics);

    /**
     * @return mixed
     */
    public function getNumberOfEmployees();

    /**
     * @param mixed $numberOfEmployees
     * @return Organization
     */
    public function setNumberOfEmployees($numberOfEmployees);

    /**
     * @return mixed
     */
    public function getOwns();

    /**
     * @param mixed $owns
     * @return Organization
     */
    public function setOwns($owns);

    /**
     * @return mixed
     */
    public function getParentOrganization();

    /**
     * @param mixed $parentOrganization
     * @return Organization
     */
    public function setParentOrganization($parentOrganization);

    /**
     * @return mixed
     */
    public function getPublishingPrinciples();

    /**
     * @param mixed $publishingPrinciples
     * @return Organization
     */
    public function setPublishingPrinciples($publishingPrinciples);

    /**
     * @return mixed
     */
    public function getReview();

    /**
     * @param mixed $review
     * @return Organization
     */
    public function setReview($review);

    /**
     * @return mixed
     */
    public function getSeeks();

    /**
     * @param mixed $seeks
     * @return Organization
     */
    public function setSeeks($seeks);

    /**
     * @return mixed
     */
    public function getSponsor();

    /**
     * @param mixed $sponsor
     * @return Organization
     */
    public function setSponsor($sponsor);

    /**
     * @return mixed
     */
    public function getSubOrganization();

    /**
     * @param mixed $subOrganization
     * @return Organization
     */
    public function setSubOrganization($subOrganization);

    /**
     * @return mixed
     */
    public function getTaxID();

    /**
     * @param mixed $taxID
     * @return Organization
     */
    public function setTaxID($taxID);

    /**
     * @return mixed
     */
    public function getTelephone();

    /**
     * @param mixed $telephone
     * @return Organization
     */
    public function setTelephone($telephone);

    /**
     * @return mixed
     */
    public function getUnnamedSourcesPolicy();

    /**
     * @param mixed $unnamedSourcesPolicy
     * @return Organization
     */
    public function setUnnamedSourcesPolicy($unnamedSourcesPolicy);

    /**
     * @return mixed
     */
    public function getVatID();

    /**
     * @param mixed $vatID
     * @return Organization
     */
    public function setVatID($vatID);
}
