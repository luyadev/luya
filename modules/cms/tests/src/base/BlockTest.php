<?php

namespace tests\web\cmsadmin\base;

use luya\cms\base\Block;
use cmstests\data\blocks\TestBlock;
use cmstests\data\blocks\FailureBlock;
use cmstests\CmsFrontendTestCase;
use luya\cms\base\PhpBlock;

class GetterSetter extends PhpBlock
{
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

    public function admin()
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


        foreach ($block->getConfigVarsExport() as $var) {
            $this->assertArrayHasKey('id', $var);
            $this->assertArrayHasKey('var', $var);
            $this->assertArrayHasKey('label', $var);
            $this->assertArrayHasKey('type', $var);
            $this->assertArrayHasKey('placeholder', $var);
            $this->assertArrayHasKey('options', $var);
            $this->assertArrayHasKey('initvalue', $var);
        }

        foreach ($block->getConfigCfgsExport() as $var) {
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

        $this->assertEquals('content var 1', $block->admin()[0]);
        $this->assertEquals('content var 2', $block->admin()[1]);
    }

    public function testGetterSetter()
    {
        $gs = new GetterSetter();

        $a = $gs->config();
        $b = $gs->name();
        $c = $gs->extraVars();
        $d = $gs->admin();

        $gs->setPlaceholderValues(['blabl' => 'Gandalf ist mein Vorbild']);
    }

    public function testAjaxCreation()
    {
        $gs = new GetterSetter();

        $this->assertNotEquals(false, $gs->createAjaxLink('DerTest'));
    }
}
