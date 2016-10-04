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
}