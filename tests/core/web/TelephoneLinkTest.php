<?php

namespace luyatests\core\web;

use luya\web\TelephoneLink;
use luyatests\LuyaWebTestCase;

class TelephoneLinkTest extends LuyaWebTestCase
{
    public function testLinkable()
    {
        $link = new TelephoneLink(['telephone' => '+000 (9) 123-456']);

        $this->assertInstanceOf('luya\web\LinkInterface', $link);

        $this->assertSame('_self', $link->getTarget());
        $this->assertSame('+000 (9) 123-456', $link->getTelephone());
        $this->assertSame('tel:+0009123456', $link->getHref());
        $this->assertSame('tel:+0009123456', $link->__toString());
    }

    public function testMissingHrefException()
    {
        $this->expectException('yii\base\InvalidConfigException');
        $link = new TelephoneLink();
    }

    public function testPrefixWithBackslash()
    {
        $link = new TelephoneLink(['telephone' => '\+49 123456']);

        $this->assertStringContainsString('+49 123456', $link->getTelephone());
        $this->assertStringContainsString('tel:+49123456', $link->getHref());
    }

    public function testInvalidNumberFromLinkConvertion()
    {
        $link = new TelephoneLink(['telephone' => 'https://luya.io']);

        $this->assertFalse($link->getTelephone());
        $this->assertNull($link->getHref());
    }
}
