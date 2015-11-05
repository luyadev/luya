<?php

namespace tests\web\admin\models;

use admin\models\Config;

class ConfigTest extends \tests\web\Base
{
    public function testSettersGetters()
    {
        $this->assertEquals('', Config::get('foo'));
        $this->assertEquals(false, Config::has('foo'));
        $this->assertEquals(true, Config::set('foo', 'bar'));
        $this->assertEquals(true, Config::has('foo'));
        $this->assertEquals('bar', Config::get('foo'));
        $this->assertEquals(true, Config::remove('foo'));
    }

    public function testUpdate()
    {
        $this->assertEquals(true, Config::set('foo2', 'baz'));
        $this->assertEquals('baz', Config::get('foo2'));
        $this->assertEquals(true, Config::set('foo2', 'xyz'));
        $this->assertEquals('xyz', Config::get('foo2'));
    }
}
