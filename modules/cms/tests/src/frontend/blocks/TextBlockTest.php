<?php

namespace cmstests\src\frontend\blocks;

use luya\cms\frontend\blocks\TextBlock;
use cmstests\BlockTestCase;

class TextBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\TextBlock';
    
    public function testEmpty()
    {
        $this->assertSame('<p></p>', $this->renderFrontendNoSpace());
    }
    
    public function testText()
    {
        $this->block->setVarValues(['content' => 'text']);
        $this->assertContains('<p>text</p>', $this->renderFrontend());
    }
    
    public function testNl2br()
    {
        $this->block->setVarValues(['content' => 'text
test']);
        $this->assertContains('<p>text<br />
test</p>', $this->renderFrontend());
    }

    public function testNoMarkdownButMarkup()
    {
        $this->block->setVarValues(['content' => '##text', 'textType' => 0]);
        $this->assertContains('<p>##text</p>', $this->renderFrontend());
    }
    
    public function testMarkdownRender()
    {
        $this->block->setVarValues(['content' => '##text', 'textType' => 1]);
        $this->assertContains('<h2>text</h2>', $this->renderFrontendNoSpace());
    }
    
    public function testCfgValue()
    {
        $this->block->setVarValues(['content' => 'text']);
        $this->block->setCfgValues(['cssClass' => 'test']);
        $this->assertContains('<p class="test">text</p>', $this->renderFrontend());
    }
    
    public function testCfgWithMarkdown()
    {
        $this->block->setVarValues(['content' => '##text', 'textType' => 0]);
        $this->block->setCfgValues(['cssClass' => 'test']);
        $this->assertContains('<p class="test">##text</p>', $this->renderFrontend());
    }
    
    public function testCfgWithMarkdownAndClass()
    {
        $this->block->setVarValues(['content' => '##text', 'textType' => 1]);
        $this->block->setCfgValues(['cssClass' => 'test']);
        $this->assertContains('<h2>text</h2>', $this->renderFrontendNoSpace());
    }
}
