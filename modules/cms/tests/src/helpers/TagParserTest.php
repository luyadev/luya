<?php

namespace cmstests\src\helpers;

use Yii;
use cms\helpers\TagParser;
use cmstests\CmsFrontendTestCase;

class TagParserTest extends CmsFrontendTestCase
{
    public function testLinkBasicParser()
    {
        $content = 'link[123] link[123](abc) link[www.google.ch] link[www.google.ch](nicht google!)';

        $response = TagParser::convert($content);

        $this->assertEquals('<a href="#link_not_found" label="123" class="link-external" target="_blank">123</a> <a href="#link_not_found" label="abc" class="link-external" target="_blank">abc</a> <a href="http://www.google.ch" label="www.google.ch" class="link-external" target="_blank">www.google.ch</a> <a href="http://www.google.ch" label="nicht google!" class="link-external" target="_blank">nicht google!</a>', $response);
    }

    public function testValidLinksParser()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        
        $content = 'link[1] link test link[]';

        $this->assertEquals('<a href="/" label="Homepage" class="link-internal" >Homepage</a> link test link[]', TagParser::convert($content));

        $content = 'link[2] link test link[]';

        $this->assertEquals('<a href="/en/page1" label="Page 1" class="link-internal" >Page 1</a> link test link[]', TagParser::convert($content));

        $content = 'link[1](label)';

        $this->assertEquals('<a href="/" label="label" class="link-internal" >label</a>', TagParser::convert($content));

        $content = 'link[2](label)';

        $this->assertEquals('<a href="/en/page1" label="label" class="link-internal" >label</a>', TagParser::convert($content));
        
        $content = 'link[3](label)';
        
        $this->assertEquals('<a href="/en/page2" label="label" class="link-internal" >label</a>', TagParser::convert($content));
    }

    public function testStaticLinksParser()
    {
        $this->assertEquals('<a href="http://luya.io" label="luya.io" class="link-external" target="_blank">luya.io</a>', TagParser::convert('link[http://luya.io](luya.io)'));
        $this->assertEquals('<a href="http://luya.io" label="Hello Whitespace" class="link-external" target="_blank">Hello Whitespace</a>', TagParser::convert('link[http://luya.io](Hello Whitespace)'));
        $this->assertEquals('<a href="http://luya.io" label="http://luya.io" class="link-external" target="_blank">http://luya.io</a>', TagParser::convert('link[http://luya.io]'));
        $this->assertEquals('<a href="http://luya.io" label="luya.io" class="link-external" target="_blank">luya.io</a>', TagParser::convert('link[luya.io]'));
        $this->assertEquals('<a href="http://luya.io" label="Hello Whitespace" class="link-external" target="_blank">Hello Whitespace</a>', TagParser::convert('link[luya.io](Hello Whitespace)'));
        $this->assertEquals('<a href="http://luya.io" label="Hello /\#~[] Chars" class="link-external" target="_blank">Hello /\#~[] Chars</a>', TagParser::convert('link[luya.io](Hello /\#~[] Chars)'));
    }

    public function testInvalidContent()
    {
        $this->assertSame(false, TagParser::convert(false));
        $this->assertSame(true, TagParser::convert(true));
        $this->assertSame(1, TagParser::convert(1));
        $this->assertSame('string', TagParser::convert('string'));
        $this->assertSame([], TagParser::convert([]));
    }
}
