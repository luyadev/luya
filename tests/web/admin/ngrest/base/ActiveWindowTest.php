<?php

namespace tests\web\admin\ngrest\base;

use admin\ngrest\render\RenderCrud;

class ActiveWindowTest extends \tests\web\Base
{
    public function testRender()
    {
        $aw = new \tests\data\aws\ActiveWindowExample();
        
        $this->assertEquals('bar', $aw->render('index', ['foo' => 'bar']));
        $this->assertEquals('index', $aw->index());
    }   
}