<?php

namespace cmstests\src\frontend\blocks;

use luya\cms\frontend\blocks\ModuleBlock;
use cmstests\BlockTestCase;

class ModuleBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\ModuleBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testModuleName()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $this->assertSame('cmsunitmodule/default/index', $this->renderFrontendNoSpace());
    }
    
    public function testCutomControllerFrontend()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setCfgValues(['moduleController' => 'foo', 'moduleAction' => 'bar']);
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
    
        $this->assertEquals('cmsunitmodule/foo/bar', $this->renderFrontendNoSpace());
    }
    
    public function testCutomControllerFrontendActionArgs()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $this->block->setCfgValues(['moduleController' => 'default', 'moduleAction' => 'with-args', 'moduleActionArgs' => '{"param":"paramvalue"}']);
        $this->assertEquals('paramvalue', $this->renderFrontendNoSpace());
    }
    
    public function testGetControlleClassses()
    {
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $ctrls = $this->block->getControllerClasses();
    
        $this->assertArrayHasKey('default', $ctrls);
        $this->assertContains('DefaultController.php', $ctrls['default']);
        $this->assertArrayHasKey('foo', $ctrls);
        $this->assertContains('FooController.php', $ctrls['foo']);
    }
    
    public function testGetModuless()
    {
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $m = $this->block->getModuleNames();
        
        $this->assertArrayHasKey('value', $m[0]);
        $this->assertArrayHasKey('label', $m[0]);
        
        $this->assertSame('CmsUnitModule', $m[0]['value']);
        $this->assertSame('CmsUnitModule', $m[0]['label']);
    }
    
    // older methods
    
    public function testRenderingFrontend()
    {
        $block = new ModuleBlock();
        $block->setEnvOption('context', 'frontend');
        $block->setVarValues(['moduleName' => 'CmsUnitModule']);

        $this->assertEquals('cmsunitmodule/default/index', $block->renderFrontend());
    }

    public function testRenderingAdmin()
    {
        $block = new ModuleBlock();
        $block->setEnvOption('context', 'admin');
        $block->setVarValues(['moduleName' => 'CmsUnitModule']);

        $this->assertEquals('{% if vars.moduleName is empty %}<span class="block__empty-text">No module has been specified yet.</span>{% else %}<p><i class="material-icons">developer_board</i> Module integration: <strong>{{ vars.moduleName }}</strong></p>{% endif %}', $block->renderAdmin());
    }
    
    public function testNotFoundException()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $this->block->setCfgValues(['moduleController' => 'not-found-controller']);
        $this->expectException('\yii\web\NotFoundHttpException');
        $this->renderFrontendNoSpace();
    }
    
    public function testBlockWithException()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        $this->block->setCfgValues(['moduleController' => 'default', 'moduleAction' => 'exception']);
        $this->expectException('\luya\cms\Exception');
        $this->renderFrontendNoSpace();
    }
    
    public function testStrictRender()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setCfgValues(['moduleController' => 'foo', 'moduleAction' => 'bar', 'strictRender' => 1]);
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
        
        $this->assertEquals('cmsunitmodule/foo/bar', $this->renderFrontendNoSpace());
    }
    
    public function testStrictRenderArgs()
    {
        $this->block->setEnvOption('context', 'frontend');
        $this->block->setCfgValues(['moduleController' => 'foo', 'moduleAction' => 'bar', 'strictRender' => 1]);
        $this->block->setVarValues(['moduleName' => 'CmsUnitModule']);
    
        $this->assertEquals('cmsunitmodule/foo/bar', $this->renderFrontendNoSpace());
    }
}
