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
    use ThingTrait {
        fields as thingFields;
    }

    /**
     * For a NewsMediaOrganization or other news-related Organization,
     * a statement about public engagement activities (for news media, the newsroom’s),
     * including involving the public - digitally or otherwise
     * -- in coverage decisions, reporting and activities after publication.
     *
     * @var CreativeWork|URL
     */
    private $_actionableFeedbackPolicy;

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
     * Physical address of the item.
     *
     * @var PostalAddress|string
     */
    private $_address;

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
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @var AggregateRating
     */
    private $_aggregateRating;

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
     * Alumni of an organization.
     * Inverse property: alumniOf.
     *
     * @var Person
     */
    private $_alumni;

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
     * The geographic area where a service or offered item is provided. Supersedes serviceArea.
     *
     * @var AdministrativeArea|GeoShape|Place|string
     */
    private $_areaServed;

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
     * An award won by or for this item. Supersedes awards.
     *
     * @var string
     */
    private $_award;

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
     * The brand(s) associated with a product or service,
     * or the brand(s) maintained by an organization or business person.
     *
     * @var Brand|Organization
     */
    private $_brand;

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
     * A contact point for a person or organization. Supersedes contactPoints.
     *
     * @var ContactPoint
     */
    private $_contactPoint;

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
     * For an Organization (e.g. NewsMediaOrganization),
     * a statement describing (in news media, the newsroom’s) disclosure and correction policy for errors.
     *
     * @var CreativeWork|URL
     */
    private $_correctionsPolicy;

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
     * A relationship between an organization and a department of that organization,
     * also described as an organization (allowing different urls, logos, opening hours).
     * For example: a store with a pharmacy, or a bakery with a cafe.
     *
     * @var Organization
     */
    private $_department;

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
     * The date that this organization was dissolved.
     *
     * @var Date
     */
    private $_dissolutionDate;

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
     * Statement on diversity policy by an Organization e.g. a NewsMediaOrganization.
     * For a NewsMediaOrganization, a statement describing the newsroom’s diversity policy on both staffing and sources,
     * typically providing staffing data.
     *
     * @var CreativeWork|URL
     */
    private $_diversityPolicy;
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
     * The Dun & Bradstreet DUNS number for identifying an organization or business person.
     *
     * @var string
     */
    private $_duns;

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
     * Email address
     *
     * @var string
     */
    private $_email;

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
     * Someone working for this organization.
     * Supersedes employees.
     *
     * @var Person
     */
    private $_employee;

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
     * Statement about ethics policy, e.g. of a NewsMediaOrganization regarding journalistic and publishing practices,
     * or of a Restaurant, a page describing food source policies. In the case of a NewsMediaOrganization,
     * an ethicsPolicy is typically a statement describing the personal, organizational,
     * and corporate standards of behavior expected by the organization.
     *
     * @var CreativeWork|URL
     */
    private $_ethicsPolicy;

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
     * Upcoming or past event associated with this place, organization, or action. Supersedes events.
     *
     * @var Event
     */
    private $_event;

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
     * The fax number.
     *
     * @var string
     */
    private $_faxNumber;

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
     * A person who founded this organization. Supersedes founders.
     *
     * @var Person
     */
    private $_founder;

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
     * The date that this organization was founded.
     *
     * @var Date
     */
    private $_foundingDate;

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
     * The place where the Organization was founded.
     *
     * @var Place
     */
    private $_foundingLocation;

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
     * A person or organization that supports (sponsors) something through some kind of financial contribution.
     *
     * @var Organization|Person
     */
    private $_funder;

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
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place.
     * The GLN is a 13-digit number used to identify parties and physical locations.
     *
     * @var string
     */
    private $_globalLocationNumber;

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
     * Indicates an OfferCatalog listing for this Organization, Person, or Service.
     *
     * @var OfferCatalog
     */
    private $_hasOfferCatalog;

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
     * Points-of-Sales operated by the organization or person.
     *
     * @var Place
     */
    private $_hasPOS;

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
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @var string
     */
    private $_isicV4;

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
     * The official name of the organization, e.g. the registered company name.
     *
     * @var string
     */
    private $_legalName;

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
     * An organization identifier that uniquely identifies a legal entity as defined in ISO 17442.
     *
     * @var string
     */
    private $_leiCode;

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
     * The location of for example where the event is happening, an organization is located,
     * or where an action takes place.
     *
     * @var Place|PostalAddress|string
     */
    private $_location;

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
     * An associated logo.
     *
     * @var ImageObject|URL
     */
    private $_logo;

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
     * A pointer to products or services offered by the organization or person.
     * Inverse property: offeredBy.
     *
     * @var Offer
     */
    private $_makesOffer;

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
     * A member of an Organization or a ProgramMembership.
     * Organizations can be members of organizations; ProgramMembership is typically for individuals.
     * Supersedes members, musicGroupMember.
     * Inverse property: memberOf.
     *
     * @var Organization|Person
     */
    private $_member;

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
     * An Organization (or ProgramMembership) to which this Person or Organization belongs.
     * Inverse property: member.
     *
     * @var Organization|ProgramMembership
     */
    private $_memberOf;

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
     * The North American Industry Classification System (NAICS) code for a particular organization or business person.
     *
     * @var string
     */
    private $_naics;

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
     * The number of employees in an organization e.g. business.
     *
     * @var QuantitativeValue
     */
    private $_numberOfEmployees;

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
     * Products owned by the organization or person.
     *
     * @var OwnershipInfo|Product
     */
    private $_owns;

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
     * The larger organization that this organization is a subOrganization of, if any.
     * Supersedes branchOf.
     * Inverse property: subOrganization.
     *
     * @var Organization
     */
    private $_parentOrganization;

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
     * The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles
     * of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher,
     * e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those
     * of the party primarily responsible for the creation of the CreativeWork.
     *
     * @var CreativeWork|URL
     */
    private $_publishingPrinciples;

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
     * A review of the item. Supersedes reviews.
     *
     * @var Review
     */
    private $_review;

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
     * A pointer to products or services sought by the organization or person (demand).
     *
     * @var Demand
     */
    private $_seeks;

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
     * A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g.
     *
     * @var Organization|Person
     */
    private $_sponsor;

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
     * A relationship between two organizations where the first includes the second, e.g., as a subsidiary.
     * See also: the more specific 'department' property.
     * Inverse property: parentOrganization.
     *
     * @var Organization
     */
    private $_subOrganization;

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
     * The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     *
     * @var string
     */
    private $_taxID;

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
     * The telephone number.
     *
     * @var string
     */
    private $_telephone;

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
     * For an Organization (typically a NewsMediaOrganization), a statement about policy on use of unnamed sources
     * and the decision process required.
     *
     * @var CreativeWork|URL
     */
    private $_unnamedSourcesPolicy;

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
     * The Value-added Tax ID of the organization or person.
     *
     * @var string
     */
    private $_vatID;

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

    /**
     * Return fields
     */
    public function fields() {
        return array_merge(['actionableFeedbackPolicy', 'address', 'aggregateRating', 'alumni', 'areaServed', 'award', 'brand', 'contactPoint', 'correctionsPolicy', 'department',
            'dissolutionDate', 'diversityPolicy', 'duns', 'email', 'employee', 'ethicsPolicy', 'event', 'faxNumber', 'founder', 'foundingDate', 'foundingLocation',
            'funder', 'globalLocationNumber', 'hasOfferCatalog', 'hasPOS', 'isicV4', 'legalName', 'leiCode', 'location', 'logo', 'makesOffer', 'member', 'memberOf',
            'naics', 'numberOfEmployees', 'owns', 'parentOrganization', 'publishingPrinciples', 'review', 'seeks', 'sponsor', 'subOrganization', 'taxID', 'telephone',
            'unnamedSourcesPolicy', 'vatID'], $this->thingFields());
    }
}