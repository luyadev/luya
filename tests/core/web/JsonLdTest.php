<?php
namespace luyatests\core\web;

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
        
        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('<script type="application/ld+json">{"@graph":[{"foo":"bar"}]}</script>', $out);
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
        
        $this->assertInstanceOf('luya\web\jsonld\BaseThing', $event);
    }

    /*
    public function testPerson()
    {
        $person = (new Person())->setName('John Doe');
        
        $this->assertSame(['name' => 'John Doe', 'givenName' => null, 'familyName' => null], $person->toArray());
      
        JsonLd::reset();
        $staticPerson = JsonLd::person()->setName('John Doe');
        
        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('{"@graph":[{"name":"John Doe","givenName":null,"familyName":null}]}', $out);
    }
    */
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

        JsonLd::reset();
        $staticThing = JsonLd::thing()->setName('The Thing');

        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();

        $this->assertContains('{"@graph":[{"name":"The Thing","description":null,"$sameAs":null}]}', $out);
    }
    
    public function testEvent()
    {
        JsonLd::reset();
        
        $address = (new Address())->setCity('Aarau');
        $location = (new Location())->setName('My Location')->setAddress($address);
        JsonLd::event()->setLocation($location);
        
        ob_start();
        $this->app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('{"@graph":[{"locations":[{"name":"My Location","addresses":[{"street":null,"zip":null,"city":"Aarau"}]}]}]}', $out);
    }


}
