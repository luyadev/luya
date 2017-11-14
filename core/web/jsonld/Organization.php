<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Organization
 *
 * @see http://schema.org/Organization
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Organization extends Thing implements OrganizationInterface
{
    use OrganizationTrait;

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
     * Physical address of the item.
     *
     * @var PostalAddress|string
     */
    private $_address;

    /**
     * The overall rating, based on a collection of reviews or ratings, of the item.
     *
     * @var AggregateRating
     */
    private $_aggregateRating;

    /**
     * Alumni of an organization.
     * Inverse property: alumniOf.
     *
     * @var Person
     */
    private $_alumni;

    /**
     * The geographic area where a service or offered item is provided. Supersedes serviceArea.
     *
     * @var AdministrativeArea|GeoShape|Place|string
     */
    private $_areaServed;

    /**
     * An award won by or for this item. Supersedes awards.
     *
     * @var string
     */
    private $_award;

    /**
     * The brand(s) associated with a product or service,
     * or the brand(s) maintained by an organization or business person.
     *
     * @var Brand|Organization
     */
    private $_brand;

    /**
     * A contact point for a person or organization. Supersedes contactPoints.
     *
     * @var ContactPoint
     */
    private $_contactPoint;

    /**
     * For an Organization (e.g. NewsMediaOrganization),
     * a statement describing (in news media, the newsroom’s) disclosure and correction policy for errors.
     *
     * @var CreativeWork|URL
     */
    private $_correctionsPolicy;

    /**
     * A relationship between an organization and a department of that organization,
     * also described as an organization (allowing different urls, logos, opening hours).
     * For example: a store with a pharmacy, or a bakery with a cafe.
     *
     * @var Organization
     */
    private $_department;

    /**
     * The date that this organization was dissolved.
     *
     * @var Date
     */
    private $_dissolutionDate;

    /**
     * Statement on diversity policy by an Organization e.g. a NewsMediaOrganization.
     * For a NewsMediaOrganization, a statement describing the newsroom’s diversity policy on both staffing and sources,
     * typically providing staffing data.
     *
     * @var CreativeWork|URL
     */
    private $_diversityPolicy;

    /**
     * The Dun & Bradstreet DUNS number for identifying an organization or business person.
     *
     * @var string
     */
    private $_duns;

    /**
     * Email address
     *
     * @var string
     */
    private $_email;

    /**
     * Someone working for this organization.
     * Supersedes employees.
     *
     * @var Person
     */
    private $_employee;

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
     * Upcoming or past event associated with this place, organization, or action. Supersedes events.
     *
     * @var Event
     */
    private $_event;

    /**
     * The fax number.
     *
     * @var string
     */
    private $_faxNumber;

    /**
     * A person who founded this organization. Supersedes founders.
     *
     * @var Person
     */
    private $_founder;

    /**
     * The date that this organization was founded.
     *
     * @var Date
     */
    private $_foundingDate;

    /**
     * The place where the Organization was founded.
     *
     * @var Place
     */
    private $_foundingLocation;

    /**
     * A person or organization that supports (sponsors) something through some kind of financial contribution.
     *
     * @var Organization|Person
     */
    private $_funder;

    /**
     * The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN)
     * of the respective organization, person, or place.
     * The GLN is a 13-digit number used to identify parties and physical locations.
     *
     * @var string
     */
    private $_globalLocationNumber;

    /**
     * Indicates an OfferCatalog listing for this Organization, Person, or Service.
     *
     * @var OfferCatalog
     */
    private $_hasOfferCatalog;

    /**
     * Points-of-Sales operated by the organization or person.
     *
     * @var Place
     */
    private $_hasPOS;

    /**
     * The International Standard of Industrial Classification of All Economic Activities (ISIC),
     * Revision 4 code for a particular organization, business person, or place.
     *
     * @var string
     */
    private $_isicV4;

    /**
     * The official name of the organization, e.g. the registered company name.
     *
     * @var string
     */
    private $_legalName;

    /**
     * An organization identifier that uniquely identifies a legal entity as defined in ISO 17442.
     *
     * @var string
     */
    private $_leiCode;

    /**
     * The location of for example where the event is happening, an organization is located,
     * or where an action takes place.
     *
     * @var Place|PostalAddress|string
     */
    private $_location;

    /**
     * An associated logo.
     *
     * @var ImageObject|URL
     */
    private $_logo;

    /**
     * A pointer to products or services offered by the organization or person.
     * Inverse property: offeredBy.
     *
     * @var Offer
     */
    private $_makesOffer;

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
     * An Organization (or ProgramMembership) to which this Person or Organization belongs.
     * Inverse property: member.
     *
     * @var Organization|ProgramMembership
     */
    private $_memberOf;

    /**
     * The North American Industry Classification System (NAICS) code for a particular organization or business person.
     *
     * @var string
     */
    private $_naics;

    /**
     * The number of employees in an organization e.g. business.
     *
     * @var QuantitativeValue
     */
    private $_numberOfEmployees;

    /**
     * Products owned by the organization or person.
     *
     * @var OwnershipInfo|Product
     */
    private $_owns;

    /**
     * The larger organization that this organization is a subOrganization of, if any.
     * Supersedes branchOf.
     * Inverse property: subOrganization.
     *
     * @var Organization
     */
    private $_parentOrganization;

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
     * A review of the item. Supersedes reviews.
     *
     * @var Review
     */
    private $_review;

    /**
     * A pointer to products or services sought by the organization or person (demand).
     *
     * @var Demand
     */
    private $_seeks;

    /**
     * A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g.
     *
     * @var Organization|Person
     */
    private $_sponsor;

    /**
     * A relationship between two organizations where the first includes the second, e.g., as a subsidiary.
     * See also: the more specific 'department' property.
     * Inverse property: parentOrganization.
     *
     * @var Organization
     */
    private $_subOrganization;

    /**
     * The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.
     *
     * @var string
     */
    private $_taxID;

    /**
     * The telephone number.
     *
     * @var string
     */
    private $_telephone;

    /**
     * For an Organization (typically a NewsMediaOrganization), a statement about policy on use of unnamed sources
     * and the decision process required.
     *
     * @var CreativeWork|URL
     */
    private $_unnamedSourcesPolicy;

    /**
     * The Value-added Tax ID of the organization or person.
     *
     * @var string
     */
    private $_vatID;

    public function fields() {
        return array_merge(['actionableFeedbackPolicy', 'address', 'aggregateRating', 'alumni', 'areaServed', 'award', 'brand', 'contactPoint', 'correctionsPolicy', 'department',
                'dissolutionDate', 'diversityPolicy', 'duns', 'email', 'employee', 'ethicsPolicy', 'event', 'faxNumber', 'founder', 'foundingDate', 'foundingLocation',
                'funder', 'globalLocationNumber', 'hasOfferCatalog', 'hasPOS', 'isicV4', 'legalName', 'leiCode', 'location', 'logo', 'makesOffer', 'member', 'memberOf',
                'naics', 'numberOfEmployees', 'owns', 'parentOrganization', 'publishingPrinciples', 'review', 'seeks', 'sponsor', 'subOrganization', 'taxID', 'telephone',
                'unnamedSourcesPolicy', 'vatID'], parent::fields());
    }
}