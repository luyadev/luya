<?php

namespace luyatests\core;

use luyatests\LuyaWebTestCase;
use luya\Hook;

class TestClass 
{
    public function helloHook($hook)
    {
        $hook->iteration('hello');
    }
    
    public function worldHook($hook)
    {
        $hook->iteration('world');
    }
}

class HookTest extends LuyaWebTestCase
{
    public function testStringHooks()
    {
        Hook::on('fooBar', function($hook) {
            return 'Hello World';
        });
        
        $this->assertSame('Hello World', Hook::string('fooBar'));
        
        Hook::on('fooBar', function($hook) {
            return 'Another';
        });
        Hook::on('fooBar', function($hook) {
            return 'Test';
        });
        
        $this->assertSame('AnotherTest', Hook::string('fooBar'));
    }
    
    public function testIterationHooks()
    {
        Hook::on('fooBar', function($hook) {
            $hook->iteration('hello');
            $hook->iteration('world');
        });
        
        $this->assertSame(['hello', 'world'], Hook::iterate('fooBar'));
        
        
        Hook::on('testIterator', function($hook) {
            $hook->iteration('hello');
            $hook->iteration('world');
        });
        
        Hook::on('testIterator', function($hook) {
            $hook->iteration('another');
            $hook->iteration('world');
        });
        
        $this->assertSame(['hello', 'world', 'another', 'world'], Hook::iterate('testIterator'));
    }
    
    public function testIterationWithObjectHooks()
    {
        $obj = new TestClass();
        Hook::on('fooBar', [$obj, 'helloHook']);
        Hook::on('fooBar', [$obj, 'worldHook']);
        
        $this->assertSame(['hello', 'world'], Hook::iterate('fooBar'));
    }
    
    public function testIterationArrayAccessHook()
    {
        Hook::on('fooBar', function($hook) {
            $hook[] = 'Hello';
            $hook[] = 'World';
            
            $hook['foo'] = 'Bar';
            $hook['unfoo'] = 'Unfoo';
            
            if ($hook['unfoo']) {
                unset($hook['unfoo']);
            }
        });
        
        $this->assertSame(['Hello', 'World', 'foo' => 'Bar'], Hook::iterate('fooBar'));
    }
    
    public function testIterationOverrideKey()
    {
        Hook::on('fooBar', function($hook) {
            $hook['test'] = 'value1';
            $hook['test'] = 'value2';
        });
        
        Hook::on('fooBar', function($hook) {
            $hook['test'] = 'value3';
            $hook['test'] = 'value4';
        });
    
        $this->assertSame(['test' => 'value4'], Hook::iterate('fooBar'));
    }
}