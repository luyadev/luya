<?php

namespace luyatests\core\helpers;

use luya\helpers\ObjectHelper;
use luyatests\data\controllers\FooController;
use luyatests\data\modules\ctrlmodule\Module;

trait XYZ
{
}

trait ABC
{
    use XYZ;
}

/**
 * Testing Object Class
 *
 * @author nadar
 *
 */
class TestObject
{
    use ABC;

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
    public function testHasTraitInstance()
    {
        $o = new TestObject();

        $this->assertTrue(ObjectHelper::isTraitInstanceOf($o, ABC::class));
        $this->assertTrue(ObjectHelper::isTraitInstanceOf($o, XYZ::class));
        $this->assertTrue(ObjectHelper::isTraitInstanceOf($o, ['no', XYZ::class]));
        $this->assertFalse(ObjectHelper::isTraitInstanceOf($o, ['foo', 'bar']));
        $this->assertTrue(ObjectHelper::isTraitInstanceOf($o, $o));
    }

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

    public function testException()
    {
        $this->expectException('Exception');
        ObjectHelper::callMethodSanitizeArguments((new TestObject()), 'm3');
    }

    public function testInstanceOf()
    {
        $var = 'foo';

        $this->assertFalse(ObjectHelper::isInstanceOf($var, new ObjectHelper(), false));
        $this->assertFalse(ObjectHelper::isInstanceOf($var, 'luya\helpers\ObjectHelper', false));
        $this->assertFalse(ObjectHelper::isInstanceOf($var, 'DoesNotExists', false));
        $this->assertFalse(ObjectHelper::isInstanceOf($var, ['luya\helpers\ObjectHelper', ObjectHelper::class], false));

        $validObject = new ObjectHelper();

        $this->assertTrue(ObjectHelper::isInstanceOf($validObject, 'luya\helpers\ObjectHelper', false));
        $this->assertTrue(ObjectHelper::isInstanceOf($validObject, ['invalid\Object', 'luya\helpers\ObjectHelper'], false));
        $this->assertTrue(ObjectHelper::isInstanceOf($validObject, [ObjectHelper::class], false));
        $this->assertTrue(ObjectHelper::isInstanceOf($validObject, [$validObject], false));
        $this->assertTrue(ObjectHelper::isInstanceOf($validObject, $validObject, false));

        $this->expectException('luya\Exception');
        $this->assertFalse(ObjectHelper::isInstanceOf('fooBar', ['\Exception']));
    }

    public function testGetActions()
    {
        $ctrl = new FooController('id', $this->app);

        $this->assertSame([
            0 => 'index',
            1 => 'xyz',
        ], ObjectHelper::getActions($ctrl));
    }

    public function testGetControllers()
    {
        $module = new Module('id');
        $ctrls = ObjectHelper::getControllers($module);
        $this->assertArrayHasKey('default', $ctrls);
    }
}
