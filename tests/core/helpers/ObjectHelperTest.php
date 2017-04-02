<?php

namespace luyatests\core\helpers;

use luya\helpers\ObjectHelper;

/**
 * Testing Object Class
 *
 * @author nadar
 *
 */
class TestObject
{
    public function m1($foo, $bar)
    {
        return [$foo, $bar];
    }
    
    public function m2($foo = null)
    {
        return $foo;
    }
    
    public function m3($foo, $bar = 'baz')
    {
        return [$foo, $bar];
    }
    
    public function m4(array $arr = [])
    {
        return $arr;
    }
}

class ObjectHelperTest extends \luyatests\LuyaWebTestCase
{
    public function testRequiredArgs()
    {
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm1', ['foo' => 1, 'bar' => 2]);
        
        $this->assertEquals(true, is_array($response));
        $this->assertEquals(2, count($response));
    }
    
    public function testOptionalArg()
    {
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm2');
        
        $this->assertSame(null, $response);
        
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm2', ['foo' => 'bar']);
        
        $this->assertSame('bar', $response);
    }
    
    public function testOptionalArgMixin()
    {
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm3', ['foo' => 'bar']);
    
        $this->assertSame(true, is_array($response));
        $this->assertArrayHasKey(0, $response);
        $this->assertArrayHasKey(1, $response);
        $this->assertEquals("bar", $response[0]);
        $this->assertEquals('baz', $response[1]);
    
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm3', ['foo' => 'bar', 'bar' => 'notbaz']);
    
        $this->assertSame(true, is_array($response));
        $this->assertArrayHasKey(0, $response);
        $this->assertArrayHasKey(1, $response);
        $this->assertEquals("bar", $response[0]);
        $this->assertEquals('notbaz', $response[1]);
    }
    
    public function testArgMixin4()
    {
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm4');
        $this->assertEquals(true, is_array($response));
        $this->assertEquals(0, count($response));
        
        $response = ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm4', ['arr' => ['foo' => 'bar']]);
        $this->assertEquals(true, is_array($response));
        $this->assertEquals(1, count($response));
        $this->assertArrayHasKey('foo', $response);
        $this->assertEquals('bar', $response['foo']);
    }
    
    /**
     *  @expectedException Exception
     *  @expectedExceptionMessage The argument 'foo' is required for method 'm3' in class 'luyatests\core\helpers\TestObject'.
     */
    public function testException()
    {
        ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm3');
    }
}
