<?php

namespace luyatests\core;

use luya\tag\BaseTag;
use luya\tag\tags\LinkTag;
use luya\TagParser;
use luyatests\LuyaWebTestCase;

class TestTag extends BaseTag
{
    public function name()
    {
        return 'testtag';
    }

    public function example()
    {
        return 'testtag';
    }

    public function readme()
    {
        return 'testtag';
    }

    public function parse($value, $sub)
    {
        if (empty($sub)) {
            return $value;
        }

        return $value . '|'. $sub;
    }
}

class Test2Tag extends TestTag
{
    public function parse($value, $sub)
    {
        return '<a href="'.$value.'">'.$sub.'</a>';
    }
}

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

    public function testProcessText()
    {
        TagParser::inject('test', ['class' => TestTag::class]);
        $this->assertSame('value', TagParser::convert('test[value]'));
        $this->assertSame('test[]', TagParser::convert('test[]'));
        $this->assertSame('value|sub', TagParser::convert('test[value](sub)'));
    }

    public function testSubValueWithBrackets()
    {
        TagParser::inject('test', ['class' => Test2Tag::class]);

        $this->assertSame('<a href="1">Example file (PDF)</a>', TagParser::convert('test[1](Example file \(PDF\))'));
    }

    public function testMarkdownNewslines()
    {
        $input = <<<EOT
First sentence
image[49287]([L-R] Caption)
second sentence
EOT;

        $this->assertSameNoSpace('<p>First sentence<br />
image[49287]([L-R] Caption)<br />
second sentence</p>', TagParser::convertWithMarkdown($input));

        $input = <<<EOT
First sentence

image[49287]([L-R] Caption)

second sentence
EOT;

        $this->assertSameNoSpace('<p>First sentence</p>
<p>image[49287]([L-R] Caption)</p>
<p>second sentence</p>', TagParser::convertWithMarkdown($input));
    }
}
