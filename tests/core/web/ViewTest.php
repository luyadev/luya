<?php

namespace luyatests\core\web;

use luya\web\View;
use luya\web\Asset;

class TestAsset extends Asset
{
	public $sourcePath = '@app';
}

class ViewTest extends \luyatests\LuyaWebTestCase
{
    public function testCompress()
    {
        $view = new View();

        $string = '  ';
        $resultString = $view->compress($string);
        $this->assertEquals(1, strlen($resultString));

        $string = ' ';
        $resultString = $view->compress($string);
        $this->assertEquals(1, strlen($resultString));

        $string = '<test>

        </test>';
        $resultString = $view->compress($string);
        $this->assertEquals(14, strlen($resultString));

        $string = 'test  test test';
        $resultString = $view->compress($string);
        $this->assertEquals(14, strlen($resultString));
    }
    
    public function testAssetUrlGetter()
    {
        $view = new View();
        TestAsset::register($view);
        $url = $view->getAssetUrl(TestAsset::class);
        $this->assertContains('c0d3b50b', $url);
    }
    
    public function testUknownAssetUrl()
    {
    	$this->expectException('luya\Exception');
    	$view = new View();
    	$view->getAssetUrl('Uknown');
    }
    
    public function testGetPublicHtml()
    {
    	$view = new View();
    	$url = $view->getPublicHtml();
    	$this->assertContains('public_html', $url);
    }
}
