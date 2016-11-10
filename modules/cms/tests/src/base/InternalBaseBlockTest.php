<?php

namespace cmstests\data\blocks;

use cmstests\CmsFrontendTestCase;

class InternalBaseBlockTest extends CmsFrontendTestCase
{
    public function testConcretImplementation()
    {
        $object = new ConcretImplementationBlock();
        
        $this->assertInstanceOf('luya\cms\base\BlockInterface', $object);
    }
}
