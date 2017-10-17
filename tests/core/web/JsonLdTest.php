<?php
namespace luyatests\core\web;

use Yii;
use luya\web\JsonLd;
use luya\web\jsonld\Event;

class JsonLdTest extends \luyatests\LuyaWebTestCase
{
    public function testAssignView()
    {
        Jsonld::addGraph(['foo' => 'bar']);
        
        ob_start();
        Yii::$app->view->beginBody();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('<script type="application/ld+json">{"@graph":[{"foo":"bar"}]}</script>', $out);
    }
    
    public function testJsonLdElementGraphNesting()
    {
    	$event = new Event();
    	
    	$event->setLocation()
    		->setName('Hallenstadion')
    		->setAddress()
    			->setCity('Zürich')
    			->setZip('8000');
    	
    	$location = $event->setLocation();
    	$location->setName('St. Jakobspark');
    	
    	$location->setAddress()
    		->setCity('ABC');
    	$location->setAddress()
    		->setCity('XYZ');
    	

		$this->assertSame([
			'locations' => [
				['name' => 'Hallenstadion', 'addresses' => [
					['street' => null, 'zip' => '8000', 'city' => 'Zürich']
				]],
				['name' => 'St. Jakobspark', 'addresses' => [
					['street' => null, 'zip' => null, 'city' => 'ABC'],
					['street' => null, 'zip' => null, 'city' => 'XYZ'],
				]]
			]
		], $event->toArray());
    	
    	$this->assertInstanceOf('luya\web\jsonld\BaseGraphElement', $event);
    }
}
