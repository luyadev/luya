<?php

namespace luyatests\core\tag\tags;

use luya\tag\tags\TelTag;
use luyatests\LuyaWebTestCase;

class TelTagTest extends LuyaWebTestCase
{
    public function testTelTag()
    {
        $tag = new TelTag();
        $this->assertSame('<a href="tel:+123">+123</a>', $tag->parse('+123', null));
        $this->assertSame('<a href="tel:+123">123</a>', $tag->parse('123', null));
        $this->assertSame('<a href="tel:+123">call</a>', $tag->parse('+123', 'call'));
        $this->assertNotNull($tag->readme());
        $this->assertNotNull($tag->example());
    }
}
