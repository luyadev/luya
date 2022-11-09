<?php

namespace luyatests\core\tag\tags;

use luya\tag\tags\LinkTag;
use luyatests\LuyaWebTestCase;

class LinkTagTest extends LuyaWebTestCase
{
    public function testLinkParser()
    {
        $link = new LinkTag();

        $this->assertNotNull($link->readme());
        $this->assertNotNull($link->example());

        $this->assertSame('<a class="link-external" href="http://none" rel="noopener" target="_blank">http://none</a>', $link->parse('none', null));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io">http://localhost/luya/envs/dev/public_html/luya.io</a>', $link->parse('//luya.io', null));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io/sub">http://localhost/luya/envs/dev/public_html/luya.io/sub</a>', $link->parse('//luya.io/sub', null));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io/sub/">http://localhost/luya/envs/dev/public_html/luya.io/sub/</a>', $link->parse('//luya.io/sub/', null));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io">http://localhost/luya/envs/dev/public_html/luya.io</a>', $link->parse('//luya.io', null));


        $this->assertSame('<a class="link-external" href="http://luya.io" rel="noopener" target="_blank">http://luya.io</a>', $link->parse('http://luya.io', null));
        $this->assertSame('<a class="link-external" href="https://luya.io" rel="noopener" target="_blank">https://luya.io</a>', $link->parse('https://luya.io', null));
        $this->assertSame('<a class="link-external" href="http://www.luya.io" rel="noopener" target="_blank">http://www.luya.io</a>', $link->parse('www.luya.io', null));
    }

    public function testLinkPaserWithSub()
    {
        $link = new LinkTag();

        $this->assertSame('<a class="link-external" href="http://none" rel="noopener" target="_blank">subalias</a>', $link->parse('none', 'subalias'));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io">subalias</a>', $link->parse('//luya.io', 'subalias'));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io/sub">subalias</a>', $link->parse('//luya.io/sub', 'subalias'));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io/sub/">subalias</a>', $link->parse('//luya.io/sub/', 'subalias'));
        $this->assertSame('<a class="link-internal" href="http://localhost/luya/envs/dev/public_html/luya.io">subalias</a>', $link->parse('//luya.io', 'subalias'));


        $this->assertSame('<a class="link-external" href="http://luya.io" rel="noopener" target="_blank">subalias</a>', $link->parse('http://luya.io', 'subalias'));
        $this->assertSame('<a class="link-external" href="https://luya.io" rel="noopener" target="_blank">subalias</a>', $link->parse('https://luya.io', 'subalias'));
        $this->assertSame('<a class="link-external" href="http://www.luya.io" rel="noopener" target="_blank">subalias</a>', $link->parse('www.luya.io', 'subalias'));
    }

    public function testRelativeLink()
    {
        $link = new LinkTag();

        $this->assertSame('<a class="link-internal" href="/go/here">/go/here</a>', $link->parse('/go/here', null));
    }
}
