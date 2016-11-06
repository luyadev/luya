<?php

namespace cmstests\src\tags;

use cmstests\CmsFrontendTestCase;
use luya\cms\tags\MenuTag;

class MenuTagTest extends CmsFrontendTestCase
{
    public function testValidLinksParser()
    {
        $tag = new MenuTag();
        
        $this->assertEquals('<a href="/luya/envs/dev/public_html/">Homepage</a>', $tag->parse(1, null));
        $this->assertEquals('<a href="/luya/envs/dev/public_html/">foobar</a>', $tag->parse(1, 'foobar'));
        
        $this->assertEquals('<a href="/luya/envs/dev/public_html/en/page1">Page 1</a>', $tag->parse(2, null));
        $this->assertEquals('<a href="/luya/envs/dev/public_html/en/page1">foobar</a>', $tag->parse(2, 'foobar'));
    }
}
