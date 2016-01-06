<?php

namespace tests\web\admin\ngrest\base;

class ActiveWindowTest extends \tests\web\Base
{
    public function testRender()
    {
        $aw = new \tests\data\aws\ActiveWindowExample();

        $this->assertEquals('bar', $aw->render('index', ['foo' => 'bar']));
        $this->assertEquals('index', $aw->index());
    }
}
