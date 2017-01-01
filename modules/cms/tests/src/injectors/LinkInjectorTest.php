<?php

namespace cmstests\src\injectors;

use cmstests\CmsFrontendTestCase;
use cmstests\data\blocks\UnitTestBlock;
use luya\cms\injectors\LinkInjector;

class StubBlock extends UnitTestBlock
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

class LinkInjectorTest extends CmsFrontendTestCase
{
    public function testLinkInjector()
    {
        $block = new StubBlock();
        $injector = new LinkInjector(['context' => $block]);
        $injector->setup();
        
        $vars = $block->getConfigVarsExport();
        
        $this->assertArrayHasKey('type', $vars[0]);
        $this->assertSame('zaa-link', $vars[0]['type']);
    }
}
