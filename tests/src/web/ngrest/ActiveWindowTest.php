<?php

namespace tests\src\web\ngrest;

use admin\ngrest\render\RenderCrud;

class ActiveWindowTest extends \tests\BaseWebTest
{
    public function testRender()
    {
        $aw = new \tests\data\ActiveWindowExample();
        
        $this->assertEquals('bar', $aw->render('index', ['foo' => 'bar']));
        $this->assertEquals('index', $aw->index());
    }   
}