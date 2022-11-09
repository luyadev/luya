<?php

namespace luyatests\core\web;

use luya\web\Element;
use Yii;

class ElementTest extends \luyatests\LuyaWebTestCase
{
    public function testElement()
    {
        $element = new \luya\web\Element();

        $element->addElement('bar', function () {
            return 'baz';
        });

        $this->assertEquals('baz', $element->getElement('bar'));
        $this->assertEquals('baz', $element->bar());
    }

    public function testPhpRenderElement()
    {
        $element = new \luya\web\Element();

        $element->addElement('rnd', function ($param) use ($element) {
            return $element->render('rnd', ['pa' => $param, 'bar' => 'baz']);
        });

        $response = $element->rnd(1);

        $this->assertEquals('1-baz', $response);
    }

    /*
    public function testPhpRenderRecursivElement()
    {
        $element = Yii::$app->element;

        $element->addElement('bar', function () {
            return 'baz';
        });

        $element->addElement('recursiv', function () use ($element) {
            return $element->render('recursiv');
        });

        $response = $element->recursiv();

        $this->assertEquals('baz', $response);
    }
    */

    public function testNotExistingElement()
    {
        $this->expectException('Exception');
        $element = new \luya\web\Element();
        // throws: The requested element 'foobar' does not exists in the element list. You may register the element first with `addElement(name, closure)`.
        $element->foobar();
    }

    public function testGetNames()
    {
        $element = new \luya\web\Element();
        $element->addElement('name', function () use ($element) {
        });

        $names = $element->getNames();

        $this->assertEquals(1, count($names));
        $this->assertEquals('name', $names[0]);
    }

    public function testGetElements()
    {
        $element = new \luya\web\Element();

        $lmns = $element->getElements();

        $this->assertEquals(0, count($lmns));
        $this->assertEquals(true, is_array($lmns));
    }

    public function testIncludeInitiConfigFile()
    {
        $element = new \luya\web\Element(['configFile' => '@unitmodule/elements.php']);

        $this->assertTrue($element->hasElement('button'));
        $this->assertTrue($element->hasElement('teaserbox'));
        $this->assertFalse($element->hasElement('foobarinsertion'));
    }

    public function testMockedArguemnts()
    {
        $element = new Element();
        $element->mockArgs('test', ['foo' => 'bar', 'param' => 'value']);
        $this->assertFalse($element->getMockedArgValue('test', 'notexists'));
        $this->assertSame('bar', $element->getMockedArgValue('test', 'foo'));
        $this->assertSame('value', $element->getMockedArgValue('test', 'param'));
    }

    public function testMockedArguemntInsideFunctionCall()
    {
        $element = new Element();
        $element->addElement('name', function () use ($element) {
            $element->mockArgs('test', ['foo' => 'bar', 'param' => 'value']);
        });
        $element->name();
        $this->assertFalse($element->getMockedArgValue('test', 'notexists'));
        $this->assertSame('bar', $element->getMockedArgValue('test', 'foo'));
        $this->assertSame('value', $element->getMockedArgValue('test', 'param'));
    }

    public function testMockedArguemntsAsMockedArgsParam()
    {
        $element = new Element();
        $element->addElement('elementName', function () use ($element) {
            // nothing happens here
        }, ['foo' => 'bar', 'param' => 'value']);
        $this->assertFalse($element->getMockedArgValue('elementName', 'notexists'));
        $this->assertSame('bar', $element->getMockedArgValue('elementName', 'foo'));
        $this->assertSame('value', $element->getMockedArgValue('elementName', 'param'));
    }

    public function testMockedArgumentsInlineElements()
    {
        $element = new \luya\web\Element(['configFile' => '@unitmodule/elementsMocked.php']);

        $this->assertFalse($element->getMockedArgValue('button', 'notexists'));
        $this->assertSame('mock1', $element->getMockedArgValue('button', 'href'));
        $this->assertSame('mock2', $element->getMockedArgValue('button', 'name'));
    }
}
