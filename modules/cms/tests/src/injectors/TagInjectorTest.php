<?php

namespace cmstests\src\injectors;

use cmstests\CmsFrontendTestCase;
use cmstests\data\blocks\UnitTestBlock;
use luya\cms\injectors\TagInjector;
use cmstests\data\fixtures\TagFixture;

class StubTagBlock extends UnitTestBlock
{
    public function name()
    {
        return 'test';
    }

    public function config()
    {
        return [];
    }
}

class TagInjectorTest extends CmsFrontendTestCase
{
    public function testTagInjector()
    {
        $model = new TagFixture();
        $model->load();
        
        $block = new StubTagBlock();
        $injector = new TagInjector(['context' => $block]);
        $injector->setup();
        
        $vars = $block->getConfigVarsExport();
       
        $this->assertContains(['items' => [
            ['value' => 2, 'label' => 'Jane'],
            ['value' => 1, 'label' => 'John'],
        ]], $vars[0]);
    }

    public function testEvalTagInjector()
    {
        $block = new StubTagBlock();
        $block->setVarValues(['tags' => [['value' => 2]]]);
        $injector = new TagInjector(['context' => $block, 'varName' => 'tags']);
        $injector->setup();
        $this->assertArrayHasKey('Jane', $injector->getAssignedTags());
    }
}
