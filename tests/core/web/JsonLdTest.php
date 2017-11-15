<?php
namespace luyatests\core\web;

use luya\web\jsonld\Organization;
use luya\web\jsonld\Thing;
use Yii;
use luya\web\JsonLd;
use luya\web\jsonld\Event;
use luya\web\jsonld\Address;
use luya\web\jsonld\Location;
use luya\web\jsonld\Person;

class JsonLdTest extends \luyatests\LuyaWebTestCase
{
    public function testAssignView()
    {
        Jsonld::addGraph(['foo' => 'bar']);
        // this test should only be run once, this its testing the script to view ld part.
        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('<script type="application/ld+json">{"@graph":[{"foo":"bar"}]}</script>', $out);
        JsonLd::reset();
    }

    public function testBaseThingGetters()
    {
    	$thing = (new Location());
    	$same = ['name', 'addresses', 'additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'potentialAction', 'sameAs', 'subjectOf', 'url'];
    	asort($same);
    	$this->assertSame($same, $thing->resolveGetterMethods());
    }
    
    public function testJsonLdElementGraphNesting()
    {
        $address1 = new Address(['city' => 'Zürich', 'zip' => '8000']);
        $address2 = new Address(['city' => 'Basel', 'zip' => '4000']);
        
        $hallenstadion = new Location(['name' => 'Hallenstadion']);
        $hallenstadion->setAddress($address1);
        
        $jakobspark = new Location(['name' => 'St. Jakobspark']);
        $jakobspark->setAddress($address1);
        $jakobspark->setAddress($address2);
        
        $event = new Event();
        $event->setLocation($hallenstadion);
        $event->setLocation($jakobspark);
        
        
        /*
        $this->assertSame([
            'locations' => [
                ['name' => 'Hallenstadion', 'addresses' => [
                    ['street' => null, 'zip' => '8000', 'city' => 'Zürich']
                ]],
                ['name' => 'St. Jakobspark', 'addresses' => [
                    ['street' => null, 'zip' => '8000', 'city' => 'Zürich'],
                    ['street' => null, 'zip' => '4000', 'city' => 'Basel'],
                ]]
            ]
        ], $event->toArray());
        */
        
        $this->assertSame([
            'additionalType' => null,
            'alternateName' => null,
            'description' => null,
            'disambiguatingDescription' => null,
            'identifier' => null,
            'image' => null,
            'locations' => Array (
                0 => Array  (
                    'additionalType' => null,
                    'addresses' => Array  (
                        0 => Array  (
                            'additionalType' => null,
                            'alternateName' => null,
                            'city' => 'Zürich',
                    'description' => null,
                            'disambiguatingDescription' => null,
                            'identifier' => null,
                            'image' => null,
                            'mainEntityOfPage' => null,
                            'name' => null,
                            'potentialAction' => null,
                            'sameAs' => null,
                            'street' => null,
                            'subjectOf' => null,
                            'url' => null,
                            'zip' => '8000',
                            ),
                        ),
                    'alternateName' => null,
                    'description' => null,
                    'disambiguatingDescription' => null,
                    'identifier' => null,
                    'image' => null,
                    'mainEntityOfPage' => null,
                    'name' => 'Hallenstadion',
            'potentialAction' => null,
                    'sameAs' => null,
                    'subjectOf' => null,
                    'url' => null,
                    ),
                1 => Array (
                    'additionalType' => null,
                    'addresses' => Array  (
                        0 => Array (
                            'additionalType' => null,
                            'alternateName' => null,
                            'city' => 'Zürich',
                    'description' => null,
                            'disambiguatingDescription' => null,
                            'identifier' => null,
                            'image' => null,
                            'mainEntityOfPage' => null,
                            'name' => null,
                            'potentialAction' => null,
                            'sameAs' => null,
                            'street' => null,
                            'subjectOf' => null,
                            'url' => null,
                            'zip' => '8000',
                            ),
                        1 => Array (
                            'additionalType' => null,
                            'alternateName' => null,
                            'city' => 'Basel',
                    'description' => null,
                            'disambiguatingDescription' => null,
                            'identifier' => null,
                            'image' => null,
                            'mainEntityOfPage' => null,
                            'name' => null,
                            'potentialAction' => null,
                            'sameAs' => null,
                            'street' => null,
                            'subjectOf' => null,
                            'url' => null,
                            'zip' => '4000',
                            ),
                        ),
                    'alternateName' => null,
                    'description' => null,
                    'disambiguatingDescription' => null,
                    'identifier' => null,
                    'image' => null,
                    'mainEntityOfPage' => null,
                    'name' => 'St. Jakobspark',
            'potentialAction' => null,
                    'sameAs' => null,
                    'subjectOf' => null,
                    'url' => null,
                    ),
                ),
            'mainEntityOfPage' => null,
            'name' => null,
            'potentialAction' => null,
            'sameAs' => null,
            'subjectOf' => null,
            'url' => null,
        ], $event->toArray());
        
        $this->assertInstanceOf('luya\web\jsonld\BaseThing', $event);
    }

    public function testThing()
    {
        $thing = (new Thing())->setName('The Thing');

        $this->assertSame([
            'additionalType' => null,
            'alternateName' => null,
            'description' => null,
            'disambiguatingDescription' => null,
            'identifier' => null,
            'image' => null,
            'mainEntityOfPage' => null,
            'name' => 'The Thing',
            'potentialAction' => null,
            'sameAs' => null,
            'subjectOf' => null,
            'url' => null
        ], $thing->toArray());
    }

    public function testOrganization()
    {
        $thing = (new Organization())->setName('The Organization');

        $fields = [
            'actionableFeedbackPolicy' => null,
            'additionalType' => null,
            'address' => null,
            'aggregateRating' => null,
            'alternateName' => null,
            'alumni' => null,
            'areaServed' => null,
            'award' => null,
            'brand' => null,
            'contactPoint' => null,
            'correctionsPolicy' => null,
            'department' => null,
            'description' => null,
            'disambiguatingDescription' => null,
            'dissolutionDate' => null,
            'diversityPolicy' => null,
            'duns' => null,
            'email' => null,
            'employee' => null,
            'ethicsPolicy' => null,
            'event' => null,
            'faxNumber' => null,
            'founder' => null,
            'foundingDate' => null,
            'foundingLocation' => null,
            'funder' => null,
            'globalLocationNumber' => null,
            'hasOfferCatalog' => null,
            'hasPOS' => null,
            'identifier' => null,
            'image' => null,
            'isicV4' => null,
            'legalName' => null,
            'leiCode' => null,
            'location' => null,
            'logo' => null,
            'mainEntityOfPage' => null,
            'makesOffer' => null,
            'member' => null,
            'memberOf' => null,
            'naics' => null,
            'name' => 'The Organization',
    'numberOfEmployees' => null,
            'owns' => null,
            'parentOrganization' => null,
            'potentialAction' => null,
            'publishingPrinciples' => null,
            'review' => null,
            'sameAs' => null,
            'seeks' => null,
            'sponsor' => null,
            'subOrganization' => null,
            'subjectOf' => null,
            'taxID' => null,
            'telephone' => null,
            'unnamedSourcesPolicy' => null,
            'url' => null,
            'vatID' => null,
        ];
        
        $this->assertSame($fields, $thing->toArray());
	}

    public function testPerson()
    {
        $thing = (new Person())->setName('The Person');

        $this->assertSame([
            'additionalName' => null,
            'additionalType' => null,
            'address' => null,
            'affiliation' => null,
            'alternateName' => null,
            'alumniOf' => null,
            'award' => null,
            'birthDate' => null,
            'birthPlace' => null,
            'brand' => null,
            'children' => null,
            'colleague' => null,
            'contactPoint' => null,
            'deathDate' => null,
            'deathPlace' => null,
            'description' => null,
            'disambiguatingDescription' => null,
            'duns' => null,
            'email' => null,
            'familyName' => null,
            'faxNumber' => null,
            'follows' => null,
            'funder' => null,
            'gender' => null,
            'givenName' => null,
            'globalLocationNumber' => null,
            'hasOccupation' => null,
            'hasOfferCatalog' => null,
            'hasPOS' => null,
            'height' => null,
            'homeLocation' => null,
            'honorificPrefix' => null,
            'honorificSuffix' => null,
            'identifier' => null,
            'image' => null,
            'isicV4' => null,
            'jobTitle' => null,
            'knows' => null,
            'mainEntityOfPage' => null,
            'makesOffer' => null,
            'memberOf' => null,
            'naics' => null,
            'name' => 'The Person',
            'nationality' => null,
            'netWorth' => null,
            'owns' => null,
            'parent' => null,
            'performerIn' => null,
            'potentialAction' => null,
            'publishingPrinciples' => null,
            'relatedTo' => null,
            'sameAs' => null,
            'seeks' => null,
            'sibling' => null,
            'sponsor' => null,
            'spouse' => null,
            'subjectOf' => null,
            'taxID' => null,
            'telephone' => null,
            'url' => null,
            'vatID' => null,
            'weight' => null,
            'workLocation' => null,
            'worksFor' => null,
        ], $thing->toArray());
    }

}
