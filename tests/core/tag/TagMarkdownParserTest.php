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
    
    private function rnl($content)
    {
        return trim(str_replace([PHP_EOL, '\n', '\r'], '', $content));
    }
}
