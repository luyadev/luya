<?php

namespace luyatests\core\traits;

use Yii;
use luyatests\LuyaWebTestCase;

class ApplicationTraitTest extends LuyaWebTestCase
{
    private $trait;
    
    public function setUp()
    {
        $this->trait = Yii::$app;
    }
    
    public function testCountApplicationModules()
    {
        $this->assertSame(4, count($this->trait->getApplicationModules()));
    }

    public function testCountFrontendModules()
    {
        $this->assertSame(3, count($this->trait->getFrontendModules()));
    }
    
    public function testLocalisation()
    {
        $app = Yii::$app;
        // default
        $this->assertContains('en_EN', $app->ensureLocale($app->language));
        $app->locales = ['de' => 'de_CH.utf'];
        $app->setLocale('de');
        $this->assertEquals('de_CH.utf', $app->ensureLocale('de'));
        $this->assertSame('de', $app->language);
    }
}
