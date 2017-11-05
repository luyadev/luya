<?php

namespace cmstests;

class BlockTestCase extends CmsFrontendTestCase
{
    public $blockClass;
    
    /**
     * @var \luya\cms\base\PhpBlock
     */
    public $block;

    public function setUp()
    {
        parent::setUp();
        
        $class = $this->blockClass;
        $this->block = new $class();
    }
    
    public function renderFrontend()
    {
        $this->assertNotEmpty($this->block->blockGroup());
        $this->assertNotEmpty($this->block->name());
        $this->assertNotEmpty($this->block->icon());
        $this->assertTrue(is_array($this->block->config()));
        $this->assertTrue(is_array($this->block->extraVars()));
        $this->assertFalse(is_array($this->block->renderAdmin()));
        $this->assertNotNull($this->block->getFieldHelp());
        return $this->block->renderFrontend();
    }
    
    public function renderAdmin()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem());
        $temp = $twig->createTemplate($this->block->renderAdmin());
        return $temp->render(['cfgs' => $this->block->getCfgValues(), 'vars' => $this->block->getVarValues()]);
    }

    public function renderAdminNoSpace()
    {
        $text = trim(preg_replace('/\s+/', ' ', $this->renderAdmin()));
        
        return str_replace(['> ', ' <'], ['>', '<'], $text);
    }
        
    public function renderFrontendNoSpace()
    {
        $text = trim(preg_replace('/\s+/', ' ', $this->renderFrontend()));
        
        return str_replace(['> ', ' <'], ['>', '<'], $text);
    }
}
