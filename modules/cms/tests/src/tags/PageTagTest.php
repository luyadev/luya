<?php

namespace cmstests\src\tags;

use luya\cms\tags\PageTag;
use cmstests\CmsFrontendTestCase;

class PageTagTest extends CmsFrontendTestCase
{
    public function testContentResponse()
    {
        $tag = new PageTag();
        $this->assertSame('<div id="layout-test"></div>', $tag->parse('1', null));
    }
    
    public function testContentPlaceholderResponse()
    {
        $tag = new PageTag();
        $this->assertSame('', $tag->parse(1, 'content'));
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testContentNotFoundException()
    {
        $tag = new PageTag();
        $tag->parse(9999, 'content');
    }
}
