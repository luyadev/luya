<?php

namespace luyatests\core\web;

use luya\web\WebsiteLink;
use luyatests\LuyaWebTestCase;

class WebsiteLinkTest extends LuyaWebTestCase
{
    public function testLinkable()
    {
        $link = new WebsiteLink(['href' => 'https://luya.io']);

        $this->assertInstanceOf('luya\web\LinkInterface', $link);

        $this->assertSame('_blank', $link->getTarget());
        $this->assertSame('https://luya.io', $link->getHref());
        $this->assertSame('https://luya.io', $link->__toString());
    }

    public function testMissingHrefException()
    {
        $this->expectException('yii\base\InvalidConfigException');
        $link = new WebsiteLink();
    }

    public function testSchemaHttpMissing()
    {
        $link = new WebsiteLink(['href' => '//go/there?p=1']);

        $this->assertStringContainsString('public_html/go/there?p=1', $link->href);
    }

    public function testTarget()
    {
        $link = new WebsiteLink(['href' => 'https://luya.io', 'target' => '_blank']);

        $this->assertSame('_blank', $link->getTarget());
    }

    public function testAnchorLink()
    {
        $link = new WebsiteLink(['href' => '#my-super-anchor']);

        $this->assertSame('#my-super-anchor', $link->getHref());

        $link = new WebsiteLink(['href' => '//page-link#my-super-anchor']);

        $this->assertStringContainsString('/page-link#my-super-anchor', $link->getHref());
    }
}
