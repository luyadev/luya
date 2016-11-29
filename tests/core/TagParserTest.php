<?php

namespace luyatests\core;

use luyatests\LuyaWebTestCase;
use luya\TagParser;
use luya\tag\tags\LinkTag;

class TagParserTest extends LuyaWebTestCase
{
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
    
    public function testContentWithMarkdown()
    {
        $this->assertSame('<p>foo</p>', trim(TagParser::convertWithMarkdown('foo')));
    }
    
    public function testInjectTag()
    {
        TagParser::inject('foo', ['class' => LinkTag::class]);
        
        $tags = TagParser::getInstantiatedTagObjects();
        
        $this->arrayHasKey('foo', $tags);
        
        $this->assertInstanceOf('luya\tag\tags\LinkTag', $tags['foo']);
    }
}
