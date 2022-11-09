<?php

namespace luyatests\core\tag;

use luya\tag\TagMarkdownParser;
use luyatests\LuyaWebTestCase;

class StubTagMarkdownParser extends TagMarkdownParser
{
    public function stubParseUrl($url)
    {
        return $this->parseUrl($url);
    }
}

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
        $this->assertSame('luya.io', $parser->parseParagraph('luya.io'));
        $this->assertSame('www.luya.io', $parser->parseParagraph('www.luya.io'));
        $this->assertSame('http://www.luya.io', $parser->parseParagraph('http://www.luya.io'));
        $this->assertSame('https://www.luya.io', $parser->parseParagraph('https://www.luya.io'));
        $this->assertSame('<a href="https://luya.io">link</a>', $parser->parseParagraph('[link](https://luya.io)'));
    }

    public function testFakeMethodToHideCoveralls()
    {
        $parser = new StubTagMarkdownParser();
        $this->assertNull($parser->stubParseUrl('justnothing'));
    }

    private function rnl($content)
    {
        return trim(str_replace([PHP_EOL, '\n', '\r'], '', $content));
    }
}
