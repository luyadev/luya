<?php

namespace luyatests\core;

use luyatests\LuyaWebTestCase;
use luya\TagParser;

class TagParserTeste extends LuyaWebTestCase
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
}