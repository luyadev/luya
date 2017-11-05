<?php

namespace luyatests\core\web;

use luyatests\LuyaWebTestCase;
use luya\web\WebsiteLink;

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

        $this->assertContains('public_html/go/there?p=1', $link->href);
    }
}
