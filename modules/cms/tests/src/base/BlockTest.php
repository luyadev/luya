<?php

namespace tests\web\cmsadmin\base;

use luya\cms\base\Block;
use cmstests\data\blocks\TestBlock;
use cmstests\data\blocks\FailureBlock;
use cmstests\CmsFrontendTestCase;

class GetterSetter extends Block
{
    public function extraVars()
    {
        return [];
    }

    public function name()
    {
        return 'name';
    }

    public function config()
    {
        return [
            'vars' => [
                ['type' => 'zaa-text', 'var' => 'blabla', 'label' => 'yolo'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '';
    }

    public function twigAdmin()
    {
        return '';
    }

    public function callbackDerTest()
    {
        return 'bar';
    }
}

class BlockTest extends CmsFrontendTestCase
{
    public function testBlockSetup()
    {
        $block = new TestBlock();

        $this->assertEquals(false, $block->isAdminContext());
        $this->assertEquals(false, $block->isFrontendContext());

        $this->assertEquals('TestBlock.twig', $block->getViewFileName('twig'));
        $this->assertEquals('twig-frontend', $block->renderFrontend());
        $this->assertEquals('<i class="material-icons">test-icon</i> <span>Test</span>', $block->getFullName());

        foreach ($block->getVars() as $var) {
            $this->assertArrayHasKey('id', $var);
            $this->assertArrayHasKey('var', $var);
            $this->assertArrayHasKey('label', $var);
            $this->assertArrayHasKey('type', $var);
            $this->assertArrayHasKey('placeholder', $var);
            $this->assertArrayHasKey('options', $var);
            $this->assertArrayHasKey('initvalue', $var);
        }

        foreach ($block->getCfgs() as $var) {
            $this->assertArrayHasKey('id', $var);
            $this->assertArrayHasKey('var', $var);
            $this->assertArrayHasKey('label', $var);
            $this->assertArrayHasKey('type', $var);
            $this->assertArrayHasKey('placeholder', $var);
            $this->assertArrayHasKey('options', $var);
            $this->assertArrayHasKey('initvalue', $var);
        }
    }

    public function testBlockValues()
    {
        $block = new TestBlock();

        $block->setEnvOption('blockId', 1);
        $block->setEnvOption('context', 'admin');

        $block->setVarValues(['var1' => 'content var 1', 'var2' => 'content var 2']);
        $block->setCfgValues(['cfg1' => 'content cfg 1']);

        $this->assertEquals('content var 1', $block->twigAdmin()[0]);
        $this->assertEquals('content var 2', $block->twigAdmin()[1]);
    }

    /**
     * @expectedException Exception
     */
    public function testBlockConfigException()
    {
        $block = new FailureBlock();
        // will throw Exception:  Required attributes in config var element is missing. var, label and type are required.
        $block->getVars();
    }

    public function testGetterSetter()
    {
        $gs = new GetterSetter();

        $a = $gs->config();
        $b = $gs->name();
        $c = $gs->extraVars();
        $d = $gs->twigAdmin();
        $e = $gs->twigFrontend();

        $gs->setPlaceholderValues(['blabl' => 'Gandalf ist mein Vorbild']);
    }

    public function testAjaxCreation()
    {
        $gs = new GetterSetter();

        $this->assertNotEquals(false, $gs->createAjaxLink('DerTest'));
    }
}
