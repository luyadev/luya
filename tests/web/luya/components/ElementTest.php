<?php

namespace tests\web\luya\components;

use Yii;

class ElementTest extends \tests\web\Base
{
    public function testElement()
    {
        $element = new \luya\components\Element();

        $element->addElement('bar', function () {
            return 'baz';
        });

        $this->assertEquals('baz', $element->run('bar'));
        $this->assertEquals('baz', $element->bar());
    }

    public function testRenderElement()
    {
        $element = new \luya\components\Element();

        $element->addElement('rnd', function ($param) use ($element) {
            return $element->render('rnd', ['pa' => $param, 'bar' => 'baz']);
        });

        $response = $element->rnd(1);

        $this->assertEquals('1-baz', $response);
    }

    public function testRenderRecursivElement()
    {
        $element = Yii::$app->element;

        $element->addElement('bar', function () {
            return 'baz';
        });

        $element->addElement('recursiv', function () use ($element) {
            return $element->render('recursiv.twig');
        });

        $response = $element->recursiv();

        $this->assertEquals('baz', $response);
    }

    /**
     * @expectedException Exception
     */
    public function testNotExistingElement()
    {
        $element = new \luya\components\Element();
        // throws: The requested element 'foobar' does not exists in the element list. You may register the element first with `addElement(name, closure)`.
        $element->foobar();
    }
}
