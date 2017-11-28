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
            'locations' => Array (
                0 => Array  (
                    'addresses' => Array  (
                        0 => Array  (
                            'city' => 'Zürich',
                            'zip' => '8000',
                            ),
                        ),
                    'name' => 'Hallenstadion',
                    ),
                1 => Array (
                    'addresses' => Array  (
                        0 => Array (
                            'city' => 'Zürich',
                            'zip' => '8000',
                            ),
                        1 => Array (
                            'city' => 'Basel',
                            'zip' => '4000',
                            ),
                        ),
                    'name' => 'St. Jakobspark',
                    ),
                ),
        ], $event->toArray());
        
        $this->assertInstanceOf('luya\web\jsonld\BaseThing', $event);
    }

    public function testThing()
    {
        $thing = (new Thing())->setName('The Thing');

        $this->assertSame([
            'name' => 'The Thing',
        ], $thing->toArray());
    }

    public function testOrganization()
    {
        $thing = (new Organization())->setName('The Organization');

        $fields = [
            'name' => 'The Organization',
        ];
        
        $this->assertSame($fields, $thing->toArray());
	}

    public function testPerson()
    {
        $thing = (new Person())->setName('The Person');

        $this->assertSame([
            'name' => 'The Person',
        ], $thing->toArray());
    }

}
