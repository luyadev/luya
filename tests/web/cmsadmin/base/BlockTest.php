<?php

namespace tests\web\cmsadmin\base;

use tests\data\TestBlock;

class BlockTest extends \tests\web\Base
{
    public function testBlockSetup()
    {
        $block = new TestBlock();
        
        $this->assertEquals(false, $block->isAdminContext());
        $this->assertEquals(false, $block->isFrontendContext());
        
        $this->assertEquals("TestBlock.twig", $block->getRenderFileName());
        $this->assertEquals("twig-frontend", $block->getTwigFrontendContent());
        $this->assertEquals('<i class="left test-icon"></i> <span>Test</span>', $block->getFullName());
        
        foreach($block->getVars() as $var) {
            $this->assertArrayHasKey("id", $var);
            $this->assertArrayHasKey("var", $var);
            $this->assertArrayHasKey("label", $var);
            $this->assertArrayHasKey("type", $var);
            $this->assertArrayHasKey("placeholder", $var);
            $this->assertArrayHasKey("options", $var);
            $this->assertArrayHasKey("initvalue", $var);
        }
        
        foreach($block->getCfgs() as $var) {
            $this->assertArrayHasKey("id", $var);
            $this->assertArrayHasKey("var", $var);
            $this->assertArrayHasKey("label", $var);
            $this->assertArrayHasKey("type", $var);
            $this->assertArrayHasKey("placeholder", $var);
            $this->assertArrayHasKey("options", $var);
            $this->assertArrayHasKey("initvalue", $var);
        }
    }
    
    public function testBlockValues()
    {
        $block = new TestBlock();

        $block->setEnvOption('blockId', 1);
        $block->setEnvOption('context', 'admin');
        
        $block->setVarValues(['var1' => 'content var 1', 'var2' => 'content var 2']);
        $block->setCfgValues(['cfg1' => 'content cfg 1']);
        
        $this->assertEquals("content var 1", $block->twigAdmin()[0]);
        $this->assertEquals("content var 2", $block->twigAdmin()[1]);
    }
}