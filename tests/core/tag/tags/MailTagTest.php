<?php

namespace luyatests\core\tag\tags;

use luyatests\LuyaWebTestCase;
use luya\tag\tags\MailTag;

class MailTagTest extends LuyaWebTestCase
{
    public function testMailObject()
    {
        $tag = new MailTag();

        $this->assertNotNull($tag->readme());
        $this->assertNotNull($tag->readme());
        
        $this->assertSame('<a href="mailto:&amp;#104;&amp;#101;&amp;#108;&amp;#108;&amp;#111;&amp;#64;&amp;#108;&amp;#117;&amp;#121;&amp;#97;&amp;#46;&amp;#105;&amp;#111;" rel="nofollow">&#104;&#101;&#108;&#108;&#111;&#64;&#108;&#117;&#121;&#97;&#46;&#105;&#111;</a>', $tag->parse('hello@luya.io', null));
        $this->assertSame('<a href="mailto:&amp;#104;&amp;#101;&amp;#108;&amp;#108;&amp;#111;&amp;#64;&amp;#108;&amp;#117;&amp;#121;&amp;#97;&amp;#46;&amp;#105;&amp;#111;" rel="nofollow">E-Mail</a>', $tag->parse('hello@luya.io', 'E-Mail'));
    }
}
