<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Organization trait
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait OrganizationTrait
{
    /**
     * @return mixed
     */
    public function getActionableFeedbackPolicy()
    {
        return $this->_actionableFeedbackPolicy;
    }

    /**
     * @param mixed $actionableFeedbackPolicy
     * @return Organization
     */
    public function setActionableFeedbackPolicy($actionableFeedbackPolicy)
    {
        $this->_actionableFeedbackPolicy[] = $actionableFeedbackPolicy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param mixed $address
     * @return Organization
     */
    public function setAddress($address)
    {
        $this->_address[] = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAggregateRating()
    {
        return $this->_aggregateRating;
    }

    /**
     * @param mixed $aggregateRating
     * @return Organization
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->_aggregateRating[] = $aggregateRating;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlumni()
    {
        return $this->_alumni;
    }

    /**
     * @param mixed $alumni
     * @return Organization
     */
    public function setAlumni($alumni)
    {
        $this->_alumni[] = $alumni;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAreaServed()
    {
        return $this->_areaServed;
    }

    /**
     * @param mixed $areaServed
     * @return Organization
     */
    public function setAreaServed($areaServed)
    {
        $this->_areaServed[] = $areaServed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAward()
    {
        return $this->_award;
    }

    /**
     * @param mixed $award
     * @return Organization
     */
    public function setAward($award)
    {
        $this->_award[] = $award;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->_brand;
    }

    /**
     * @param mixed $brand
     * @return Organization
     */
    public function setBrand($brand)
    {
        $this->_brand[] = $brand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPoint()
    {
        return $this->_contactPoint;
    }

    /**
     * @param mixed $contactPoint
     * @return Organization
     */
    public function setContactPoint($contactPoint)
    {
        $this->_contactPoint[] = $contactPoint;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCorrectionsPolicy()
    {
        return $this->_correctionsPolicy;
    }

    /**
     * @param mixed $correctionsPolicy
     * @return Organization
     */
    public function setCorrectionsPolicy($correctionsPolicy)
    {
        $this->_correctionsPolicy[] = $correctionsPolicy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->_department;
    }

    /**
     * @param mixed $department
     * @return Organization
     */
    public function setDepartment($department)
    {
        $this->_department[] = $department;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDissolutionDate()
    {
        return $this->_dissolutionDate;
    }

    /**
     * @param mixed $dissolutionDate
     * @return Organization
     */
    public function setDissolutionDate($dissolutionDate)
    {
        $this->_dissolutionDate[] = $dissolutionDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiversityPolicy()
    {
        return $this->_diversityPolicy;
    }

    /**
     * @param mixed $diversityPolicy
     * @return Organization
     */
    public function setDiversityPolicy($diversityPolicy)
    {
        $this->_diversityPolicy[] = $diversityPolicy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuns()
    {
        return $this->_duns;
    }

    /**
     * @param mixed $duns
     * @return Organization
     */
    public function setDuns($duns)
    {
        $this->_duns[] = $duns;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     * @return Organization
     */
    public function setEmail($email)
    {
        $this->_email[] = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->_employee;
    }

    /**
     * @param mixed $employee
     * @return Organization
     */
    public function setEmployee($employee)
    {
        $this->_employee[] = $employee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEthicsPolicy()
    {
        return $this->_ethicsPolicy;
    }

    /**
     * @param mixed $ethicsPolicy
     * @return Organization
     */
    public function setEthicsPolicy($ethicsPolicy)
    {
        $this->_ethicsPolicy[] = $ethicsPolicy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->_event;
    }

    /**
     * @param mixed $event
     * @return Organization
     */
    public function setEvent($event)
    {
        $this->_event[] = $event;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFaxNumber()
    {
        return $this->_faxNumber;
    }

    /**
     * @param mixed $faxNumber
     * @return Organization
     */
    public function setFaxNumber($faxNumber)
    {
        $this->_faxNumber[] = $faxNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFounder()
    {
        return $this->_founder;
    }

    /**
     * @param mixed $founder
     * @return Organization
     */
    public function setFounder($founder)
    {
        $this->_founder[] = $founder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoundingDate()
    {
        return $this->_foundingDate;
    }

    /**
     * @param mixed $foundingDate
     * @return Organization
     */
    public function setFoundingDate($foundingDate)
    {
        $this->_foundingDate[] = $foundingDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoundingLocation()
    {
        return $this->_foundingLocation;
    }

    /**
     * @param mixed $foundingLocation
     * @return Organization
     */
    public function setFoundingLocation($foundingLocation)
    {
        $this->_foundingLocation[] = $foundingLocation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFunder()
    {
        return $this->_funder;
    }

    /**
     * @param mixed $funder
     * @return Organization
     */
    public function setFunder($funder)
    {
        $this->_funder[] = $funder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGlobalLocationNumber()
    {
        return $this->_globalLocationNumber;
    }

    /**
     * @param mixed $globalLocationNumber
     * @return Organization
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->_globalLocationNumber[] = $globalLocationNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHasOfferCatalog()
    {
        return $this->_hasOfferCatalog;
    }

    /**
     * @param mixed $hasOfferCatalog
     * @return Organization
     */
    public function setHasOfferCatalog($hasOfferCatalog)
    {
        $this->_hasOfferCatalog[] = $hasOfferCatalog;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHasPOS()
    {
        return $this->_hasPOS;
    }

    /**
     * @param mixed $hasPOS
     * @return Organization
     */
    public function setHasPOS($hasPOS)
    {
        $this->_hasPOS[] = $hasPOS;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsicV4()
    {
        return $this->_isicV4;
    }

    /**
     * @param mixed $isicV4
     * @return Organization
     */
    public function setIsicV4($isicV4)
    {
        $this->_isicV4[] = $isicV4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLegalName()
    {
        return $this->_legalName;
    }

    /**
     * @param mixed $legalName
     * @return Organization
     */
    public function setLegalName($legalName)
    {
        $this->_legalName[] = $legalName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeiCode()
    {
        return $this->_leiCode;
    }

    /**
     * @param mixed $leiCode
     * @return Organization
     */
    public function setLeiCode($leiCode)
    {
        $this->_leiCode[] = $leiCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @param mixed $location
     * @return Organization
     */
    public function setLocation($location)
    {
        $this->_location[] = $location;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->_logo;
    }

    /**
     * @param mixed $logo
     * @return Organization
     */
    public function setLogo($logo)
    {
        $this->_logo[] = $logo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMakesOffer()
    {
        return $this->_makesOffer;
    }

    /**
     * @param mixed $makesOffer
     * @return Organization
     */
    public function setMakesOffer($makesOffer)
    {
        $this->_makesOffer[] = $makesOffer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->_member;
    }

    /**
     * @param mixed $member
     * @return Organization
     */
    public function setMember($member)
    {
        $this->_member[] = $member;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberOf()
    {
        return $this->_memberOf;
    }

    /**
     * @param mixed $memberOf
     * @return Organization
     */
    public function setMemberOf($memberOf)
    {
        $this->_memberOf[] = $memberOf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNaics()
    {
        return $this->_naics;
    }

    /**
     * @param mixed $naics
     * @return Organization
     */
    public function setNaics($naics)
    {
        $this->_naics[] = $naics;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberOfEmployees()
    {
        return $this->_numberOfEmployees;
    }

    /**
     * @param mixed $numberOfEmployees
     * @return Organization
     */
    public function setNumberOfEmployees($numberOfEmployees)
    {
        $this->_numberOfEmployees[] = $numberOfEmployees;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwns()
    {
        return $this->_owns;
    }

    /**
     * @param mixed $owns
     * @return Organization
     */
    public function setOwns($owns)
    {
        $this->_owns[] = $owns;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentOrganization()
    {
        return $this->_parentOrganization;
    }

    /**
     * @param mixed $parentOrganization
     * @return Organization
     */
    public function setParentOrganization($parentOrganization)
    {
        $this->_parentOrganization[] = $parentOrganization;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishingPrinciples()
    {
        return $this->_publishingPrinciples;
    }

    /**
     * @param mixed $publishingPrinciples
     * @return Organization
     */
    public function setPublishingPrinciples($publishingPrinciples)
    {
        $this->_publishingPrinciples[] = $publishingPrinciples;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->_review;
    }

    /**
     * @param mixed $review
     * @return Organization
     */
    public function setReview($review)
    {
        $this->_review[] = $review;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeeks()
    {
        return $this->_seeks;
    }

    /**
     * @param mixed $seeks
     * @return Organization
     */
    public function setSeeks($seeks)
    {
        $this->_seeks[] = $seeks;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSponsor()
    {
        return $this->_sponsor;
    }

    /**
     * @param mixed $sponsor
     * @return Organization
     */
    public function setSponsor($sponsor)
    {
        $this->_sponsor[] = $sponsor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubOrganization()
    {
        return $this->_subOrganization;
    }

    /**
     * @param mixed $subOrganization
     * @return Organization
     */
    public function setSubOrganization($subOrganization)
    {
        $this->_subOrganization[] = $subOrganization;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxID()
    {
        return $this->_taxID;
    }

    /**
     * @param mixed $taxID
     * @return Organization
     */
    public function setTaxID($taxID)
    {
        $this->_taxID[] = $taxID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * @param mixed $telephone
     * @return Organization
     */
    public function setTelephone($telephone)
    {
        $this->_telephone[] = $telephone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnnamedSourcesPolicy()
    {
        return $this->_unnamedSourcesPolicy;
    }

    /**
     * @param mixed $unnamedSourcesPolicy
     * @return Organization
     */
    public function setUnnamedSourcesPolicy($unnamedSourcesPolicy)
    {
        $this->_unnamedSourcesPolicy[] = $unnamedSourcesPolicy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVatID()
    {
        return $this->_vatID;
    }

    /**
     * @param mixed $vatID
     * @return Organization
     */
    public function setVatID($vatID)
    {
        $this->_vatID[] = $vatID;
        return $this;
    }
}