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
        
        $this->assertContains('<a href="mailto:', $tag->parse('hello@luya.io', null));
        $this->assertContains('E-Mail</a>', $tag->parse('hello@luya.io', 'E-Mail'));
    }
}
