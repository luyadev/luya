<?php

namespace luyatests\core\tag\tags;

use luya\tag\tags\MailTag;
use luyatests\LuyaWebTestCase;

class MailTagTest extends LuyaWebTestCase
{
    public function testMailObject()
    {
        $tag = new MailTag();

        $this->assertNotNull($tag->readme());
        $this->assertNotNull($tag->readme());

        $this->assertSame('<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#104;&#101;&#108;&#108;&#111;&#64;&#108;&#117;&#121;&#97;&#46;&#105;&#111;" rel="nofollow">&#104;&#101;&#108;&#108;&#111;&#64;&#108;&#117;&#121;&#97;&#46;&#105;&#111;</a>', $tag->parse('hello@luya.io', null));
        $this->assertSame('<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#104;&#101;&#108;&#108;&#111;&#64;&#108;&#117;&#121;&#97;&#46;&#105;&#111;" rel="nofollow">E-Mail</a>', $tag->parse('hello@luya.io', 'E-Mail'));

        $tag->obfuscate = false;

        $this->assertSame('<a href="mailto:foo@luya.io" rel="nofollow">foo@luya.io</a>', $tag->parse('foo@luya.io', null));
        $this->assertSame('<a href="mailto:foo@luya.io" rel="nofollow">text</a>', $tag->parse('foo@luya.io', 'text'));
    }
}
