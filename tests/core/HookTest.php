<?php

namespace luyatests\core;

use luya\Hook;
use luyatests\LuyaWebTestCase;

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

    public function testingString($otherNameForHook)
    {
        $otherNameForHook->iteration('testing');
    }
}

class HookTest extends LuyaWebTestCase
{
    public function testStringHooks()
    {
        Hook::on('fooBar', function ($hook) {
            return 'Hello World';
        });

        $this->assertSame('Hello World', Hook::string('fooBar'));

        Hook::on('fooBar', function ($hook) {
            return 'Another';
        });
        Hook::on('fooBar', function ($hook) {
            return 'Test';
        });

        $this->assertSame('AnotherTest', Hook::string('fooBar'));
    }

    public function testIterationHooks()
    {
        Hook::on('fooBar', function ($hook) {
            $hook->iteration('hello');
            $hook->iteration('world');
        });

        $this->assertSame(['hello', 'world'], Hook::iterate('fooBar'));


        Hook::on('testIterator', function ($hook) {
            $hook->iteration('hello');
            $hook->iteration('world');
        });

        Hook::on('testIterator', function ($hook) {
            $hook->iteration('another');
            $hook->iteration('world');
        });

        $this->assertSame(['hello', 'world', 'another', 'world'], Hook::iterate('testIterator'));
    }

    public function testIterationWithObjectHooks()
    {
        $obj = new TestClass();
        Hook::on('fooBarObjectArray', [$obj, 'helloHook']);
        Hook::on('fooBarObjectArray', [$obj, 'worldHook']);
        Hook::on('fooBarObjectArray', [$obj, 'testingString']);

        $this->assertSame(['hello', 'world', 'testing'], Hook::iterate('fooBarObjectArray'));
    }

    public function testIterationArrayAccessHook()
    {
        Hook::on('fooBar', function ($hook) {
            $hook[] = 'Hello';
            $hook[] = 'World';

            $hook['foo'] = 'Bar';
            $hook['unfoo'] = 'Unfoo';

            if (isset($hook['unfoo'])) {
                unset($hook['unfoo']);
            }
        });

        $this->assertSame(['Hello', 'World', 'foo' => 'Bar'], Hook::iterate('fooBar'));
    }

    public function testIterationGetOffsetArrayAccessHook()
    {
        Hook::on('fooBar', function ($hook) {
            $hook['foo'] = 'Bar';

            if (isset($hook['foo'])) {
                $hook['newfoo'] = $hook['foo'];
                unset($hook['foo']);
            }
        });

        $this->assertArrayHasKey('newfoo', Hook::iterate('fooBar'));
    }

    public function testIterationOverrideKey()
    {
        Hook::on('fooBar', function ($hook) {
            $hook['test'] = 'value1';
        });

        Hook::on('fooBar', function ($hook) {
            $hook['test'] = 'value4';
        });

        $this->assertSame(['test' => 'value4'], Hook::iterate('fooBar'));
    }

    public function testPrepanding()
    {
        Hook::on('prepand', function () {
            return 'test1';
        });
        Hook::on('prepand', function () {
            return 'test2';
        }, true);

        $this->assertSame('test2test1', Hook::string('prepand'));
    }

    public function testPrepandingMultipleKeys()
    {
        Hook::on('prepand', function () {
            return 'test1';
        });
        Hook::on('prepand', function () {
            return 'test2';
        });
        Hook::on('prepand', function () {
            return 'testA';
        }, true);
        Hook::on('prepand', function () {
            return 'test3';
        });
        Hook::on('prepand', function () {
            return 'testB';
        }, true);

        $this->assertSame('testBtestAtest1test2test3', Hook::string('prepand'));
    }

    public function testNotFoundListenerOutput()
    {
        $this->assertSame([], Hook::iterate('notFoundArray'));
        $this->assertSame('', Hook::string('notFoundString'));
    }

    public function testInvalidHandlerException()
    {
        Hook::on('fooException', 'notexisting');

        $this->expectException('luya\Exception');
        Hook::string('fooException');
    }
}
