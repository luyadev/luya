<?php
namespace luyatests\core\web;

use luya\web\jsonld\Organization;
use luya\web\jsonld\Thing;
use luya\web\JsonLd;
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
    	$thing = (new Thing());
    	$same = ['name', 'additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'potentialAction', 'sameAs', 'subjectOf', 'url'];
    	sort($same);
    	$this->assertSame($same, $thing->resolveGetterMethods());
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
            '@type' => 'Organization',
        ];
        
        $this->assertSame($fields, $thing->toArray());
	}

    public function testPerson()
    {
        $thing = (new Person())->setName('The Person');

        $this->assertSame([
            'name' => 'The Person',
            '@type' => 'Person',
        ], $thing->toArray());
    }

}
