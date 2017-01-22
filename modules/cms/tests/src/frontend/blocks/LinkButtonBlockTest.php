<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class LinkButtonBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\LinkButtonBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testLinkLinkSource()
    {
        $this->block->setVarValues([
            'linkData' => ['type' => 2, 'value' => 'https://luya.io']
        ]);
        $this->assertSame('<a class="btn btn-default" href="https://luya.io"></a>', $this->renderFrontendNoSpace());
    }
    
    public function testLinkLinkSourceWithLabel()
    {
        $this->block->setVarValues(['label' => 'label', 'linkData' => ['type' => 2, 'value' => 'https://luya.io']]);
        $this->assertSame('<a class="btn btn-default" href="https://luya.io">label</a>', $this->renderFrontendNoSpace());
    }
    
    public function testLinkLinkSourceWithLabelBlank()
    {
        $this->block->setVarValues(['label' => 'label', 'linkData' => ['type' => 2, 'value' => 'https://luya.io']]);
        $this->block->setCfgValues(['targetBlank' => 1]);
        $this->assertSame('<a class="btn btn-default" href="https://luya.io" target="_blank">label</a>', $this->renderFrontendNoSpace());
    }
    
    public function testLinkLinkSourceWithLabelBlankSimpleLink()
    {
        $this->block->setVarValues(['label' => 'label', 'linkData' => ['type' => 2, 'value' => 'https://luya.io']]);
        $this->block->setCfgValues(['targetBlank' => 1, 'simpleLink' => 1]);
        $this->assertSame('<a href="https://luya.io" target="_blank">label</a>', $this->renderFrontendNoSpace());
    }
}
