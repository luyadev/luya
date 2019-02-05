<?php

namespace luyatests\core\web;

use luya\web\EmailLink;
use luyatests\LuyaWebTestCase;

class EmailLinkTest extends LuyaWebTestCase
{
    public function testLinkable()
    {
        $email = new EmailLink(['email' => 'john@luya.io']);

        $this->assertInstanceOf('luya\web\LinkInterface', $email);

        $this->assertSame('_blank', $email->getTarget());
        $this->assertSame('john@luya.io', $email->getEmail());
        $this->assertSame('mailto:john@luya.io', $email->getHref());
        $this->assertSame('mailto:john@luya.io', $email->__toString());
    }

    public function testMissingHrefException()
    {
        $this->expectException('yii\base\InvalidConfigException');
        $email = new EmailLink();
    }

    public function testInvalidEmail()
    {
        $email = new EmailLink(['email' => 'notvalid']);
        $this->assertFalse($email->getEmail());
        $this->assertNull($email->getHref());
    }
}
