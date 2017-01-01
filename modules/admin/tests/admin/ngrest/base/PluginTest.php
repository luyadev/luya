<?php

namespace admintests\admin\ngrest\base;

use admintests\AdminTestCase;
use admintests\data\stubs\StubPlugin;

class PluginTest extends AdminTestCase
{
    public $plugin;
    public $plugini18n;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->plugin = new StubPlugin(['name' => 'myField', 'alias' => 'Stub Label', 'i18n' => false]);
        $this->plugini18n = new StubPlugin(['name' => 'myField', 'alias' => 'Stub Label', 'i18n' => true]);
    }
    public function testInit()
    {
        $this->expectException('luya\Exception');
        $plugin = new StubPlugin();
    }
    
    public function testGetServiceName()
    {
        $this->assertSame('service.myField.fooBar', $this->plugin->getServiceName('fooBar'));
    }
}
