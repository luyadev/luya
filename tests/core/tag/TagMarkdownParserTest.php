<?php

namespace luyatests\core\tag;

use luyatests\LuyaWebTestCase;
use luya\tag\TagMarkdownParser;

class TagMarkdownParserTest extends LuyaWebTestCase
{
    public function testNewline()
    {
        $parser = new TagMarkdownParser();
        $this->assertEquals('<p>test  test</p>', $this->rnl($parser->parse('test  test')));
        $this->assertEquals('<p>test<br />test</p>', $this->rnl($parser->parse('test'.PHP_EOL.'test')));
        $this->assertEquals('<p>test<br />test</p>', $this->rnl($parser->parse('test<br />test')));
    }
    
    public function testWithoutNewline()
    {
        $parser = new TagMarkdownParser();
        $parser->enableNewlines = false;
        $this->assertEquals('<p>new<br />line</p>', $this->rnl($parser->parse('new  '.PHP_EOL.'line')));
        $this->assertEquals('<p>testtest</p>', $this->rnl($parser->parse('test'.PHP_EOL.'test')));
    }
    
    public function testParseUrlDisabled()
    {
        $parser = new TagMarkdownParser();
        $parser->enableNewlines = false;
        $this->assertSame('luya.io', 'luya.io');
        $this->assertSame('www.luya.io', 'www.luya.io');
        $this->assertSame('http://www.luya.io', 'http://www.luya.io');
        $this->assertSame('https://www.luya.io', 'https://www.luya.io');
    }
    
    private function rnl($content)
    {
        return trim(str_replace([PHP_EOL, '\n', '\r'], '', $content));
    }
}
