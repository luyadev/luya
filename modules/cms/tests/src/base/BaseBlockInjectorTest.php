<?php

namespace cmstests\src\base;

use cmstests\CmsFrontendTestCase;
use cmstests\data\blocks\UnitTestBlock;
use luya\cms\base\BaseBlockInjector;

class StubBlock extends UnitTestBlock
{
    public function name()
    {
        return 'test';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'text-input', 'type' => 'zaa-text', 'label' => 'text'],
            ],
        ];
    }
}

class StubInjector extends BaseBlockInjector
{
    /**
     * @inheritdoc
     */
    public function setup()
    {
        $this->setContextConfig([
            'var' => $this->varName,
            'label' => $this->varLabel,
            'type' => 'injector-test',
        ]);
         
        $this->context->addExtraVar($this->varName, 'injector-output');
    }
}

class LinkInjectorTest extends CmsFrontendTestCase
{
    public function testLinkInjector()
    {
        $block = new StubBlock();
        $injector = new StubInjector(['context' => $block]);
        $injector->setup();

        $cfgs = $block->getConfigVarsExport();
        
        $this->assertSame('injector-test', $cfgs[0]['type']);
        $this->assertSame('zaa-text', $cfgs[1]['type']);
    }
    
    public function testAppendOfVar()
    {
        $block = new StubBlock();
        $injector = new StubInjector(['context' => $block, 'append' => true]);
        $injector->setup();
    
        $cfgs = $block->getConfigVarsExport();
    
        $this->assertSame('injector-test', $cfgs[1]['type']);
        $this->assertSame('zaa-text', $cfgs[0]['type']);
    }
}
