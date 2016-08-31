<?php

namespace cmstests\src\helpers;

use Yii;
use luya\cms\helpers\TagParser;
use cmstests\CmsFrontendTestCase;

class TagParserTest extends CmsFrontendTestCase
{
    public function testLinkBasicParser()
    {
        $content = 'link[123] link[123](abc) link[www.google.ch] link[www.google.ch](nicht google!)';

        $response = TagParser::convert($content);

        $this->assertEquals('<a href="#link_not_found" label="#link_not_found" class="link-external" target="_blank">#link_not_found</a> <a href="#link_not_found" label="abc" class="link-external" target="_blank">abc</a> <a href="http://www.google.ch" label="http://www.google.ch" class="link-external" target="_blank">http://www.google.ch</a> <a href="http://www.google.ch" label="nicht google!" class="link-external" target="_blank">nicht google!</a>', $response);
    }

    public function testValidLinksParser()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        
        $content = 'link[1] link test link[]';

        $this->assertEquals('<a href="/" label="Homepage" class="link-internal">Homepage</a> link test link[]', TagParser::convert($content));

        $content = 'link[2] link test link[]';

        $this->assertEquals('<a href="/en/page1" label="Page 1" class="link-internal">Page 1</a> link test link[]', TagParser::convert($content));

        $content = 'link[1](label)';

        $this->assertEquals('<a href="/" label="label" class="link-internal">label</a>', TagParser::convert($content));

        $content = 'link[2](label)';

        $this->assertEquals('<a href="/en/page1" label="label" class="link-internal">label</a>', TagParser::convert($content));
        
        $content = 'link[3](label)';
        
        $this->assertEquals('<a href="/en/page2" label="label" class="link-internal">label</a>', TagParser::convert($content));
    }

    public function testStaticLinksParser()
    {
        $this->assertEquals('<a href="http://luya.io" label="luya.io" class="link-external" target="_blank">luya.io</a>', TagParser::convert('link[http://luya.io](luya.io)'));
        $this->assertEquals('<a href="http://luya.io" label="Hello Whitespace" class="link-external" target="_blank">Hello Whitespace</a>', TagParser::convert('link[http://luya.io](Hello Whitespace)'));
        $this->assertEquals('<a href="http://luya.io" label="http://luya.io" class="link-external" target="_blank">http://luya.io</a>', TagParser::convert('link[http://luya.io]'));
        $this->assertEquals('<a href="http://luya.io" label="http://luya.io" class="link-external" target="_blank">http://luya.io</a>', TagParser::convert('link[luya.io]'));
        $this->assertEquals('<a href="http://luya.io" label="Hello Whitespace" class="link-external" target="_blank">Hello Whitespace</a>', TagParser::convert('link[luya.io](Hello Whitespace)'));
        $this->assertEquals('<a href="http://luya.io" label="Hello /\#~[] Chars" class="link-external" target="_blank">Hello /\#~[] Chars</a>', TagParser::convert('link[luya.io](Hello /\#~[] Chars)'));
    }

    public function testInvalidContent()
    {
        $this->assertSame(false, TagParser::convert(false));
        $this->assertSame(true, TagParser::convert(true));
        $this->assertSame(1, TagParser::convert(1));
        $this->assertSame(0, TagParser::convert(0));
        $this->assertSame('string', TagParser::convert('string'));
        $this->assertSame([], TagParser::convert([]));
        $this->assertSame('', TagParser::convert(''));
    }
    
    public function testNewInternalContent()
    {
        $this->assertSame('<a href="http://localhost/luya/envs/dev/public_html/link/goes/here" label="http://localhost/luya/envs/dev/public_html/link/goes/here" class="link-internal">http://localhost/luya/envs/dev/public_html/link/goes/here</a>', TagParser::convert('link[//link/goes/here]'));
        $this->assertSame('<a href="http://localhost/luya/envs/dev/public_html/link/goes/here" label="label" class="link-internal">label</a>', TagParser::convert('link[//link/goes/here](label)'));
    }

    public function testMarkdownConflict()
    {
        $this->assertEquals('<p>before <a href="http://www.luya.io" label="http://www.luya.io" class="link-external" target="_blank">http://www.luya.io</a> after</p>', $this->rnl(TagParser::convertWithMarkdown('before link[www.luya.io] after')));
        $this->assertEquals('<p>[www.luya.io]</p>', $this->rnl(TagParser::convertWithMarkdown('[www.luya.io]')));
        $this->assertEquals('<p><a href="url">www.luya.io</a></p>', $this->rnl(TagParser::convertWithMarkdown('[www.luya.io](url)')));
        $this->assertEquals('<p><a href="http://www.luya.io" label="url" class="link-external" target="_blank">url</a></p>', $this->rnl(TagParser::convertWithMarkdown('link[www.luya.io](url)')));
        $this->assertEquals('<p>www.url.com</p>', $this->rnl(TagParser::convertWithMarkdown('www.url.com')));
        $this->assertEquals('<p>http://www.url.com</p>', $this->rnl(TagParser::convertWithMarkdown('http://www.url.com')));
        $this->assertEquals('<p>&lt;www.url.com&gt;</p>', $this->rnl(TagParser::convertWithMarkdown('<www.url.com>')));
    }
    
    public function testMailParser()
    {
        $this->assertSame('<a href="mailto:info@luya.io">info@luya.io</a>', TagParser::convert('mail[info@luya.io]'));
        $this->assertSame('<a href="mailto:info@luya.io">Contact us</a>', TagParser::convert('mail[info@luya.io](Contact us)'));
    }
    
    private function rnl($content)
    {
        return trim(preg_replace('/\s\s+/', ' ', $content));
    }
}
