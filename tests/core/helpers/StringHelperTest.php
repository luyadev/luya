<?php

namespace luyatests\core\helpers;

use luya\helpers\StringHelper;
use luyatests\LuyaWebTestCase;

class StringHelperTest extends LuyaWebTestCase
{
    public function testStringTypeCast()
    {
        $this->assertSame(0, StringHelper::typeCast("0"));
        $this->assertSame(1, StringHelper::typeCast('1'));
        $this->assertSame('string', StringHelper::typeCast('string'));
        $this->assertSame([1=>'bar'], StringHelper::typeCast(['1' => 'bar']));
    }
    
    public function testReplaceFirst()
    {
        $this->assertSame('abc 123 123', StringHelper::replaceFirst('123', 'abc', '123 123 123'));
        $this->assertSame('abc 123 ABC', StringHelper::replaceFirst('ABC', '123', 'abc ABC ABC'));
    }

    public function testIsFloat()
    {
        $this->assertTrue(StringHelper::isFloat('1.0'));
        $this->assertTrue(StringHelper::isFloat("1.0"));
        $this->assertTrue(StringHelper::isFloat(1.0));
        $this->assertTrue(StringHelper::isFloat(1));
        $this->assertTrue(StringHelper::isFloat('1'));
        $this->assertTrue(StringHelper::isFloat('-1'));
        $float = 1.0;
        $this->assertTrue(StringHelper::isFloat($float));
        
        $this->assertFalse(StringHelper::isFloat('string'));
    }
    
    public function testTypeCastNumeric()
    {
        $this->assertSame(1, StringHelper::typeCastNumeric('1'));
        $this->assertSame(1.5, StringHelper::typeCastNumeric('1.5'));
        $this->assertSame(-1, StringHelper::typeCastNumeric('-1'));
        $this->assertSame(-1.5, StringHelper::typeCastNumeric('-1.5'));
        
        $this->assertSame(1, StringHelper::typeCastNumeric(1));
        $this->assertSame(1.5, StringHelper::typeCastNumeric(1.5));
        $this->assertSame(-1, StringHelper::typeCastNumeric(-1));
        $this->assertSame(-1.5, StringHelper::typeCastNumeric(-1.5));
        
        $this->assertSame(1, StringHelper::typeCastNumeric(true));
        $this->assertSame(0, StringHelper::typeCastNumeric(false));
        $this->assertSame('string', StringHelper::typeCastNumeric('string'));
        $this->assertSame([], StringHelper::typeCastNumeric([]));
    }
    
    public function testContains()
    {
        $this->assertTrue(StringHelper::contains('z', 'abzef'));
        $this->assertTrue(StringHelper::contains('1', 'test1'));
        $this->assertFalse(StringHelper::contains('B', 'abc'));
        $this->assertFalse(StringHelper::contains('@', 'nomail'));
        $this->assertTrue(StringHelper::contains('@', 'joh@doe.com'));
        $this->assertTrue(StringHelper::contains('.', 'john@doe.com'));
        $this->assertTrue(StringHelper::contains('word', 'thewordexists'));
        $this->assertFalse(StringHelper::contains('word', 'theWORDexists'));
        $this->assertfalse(StringHelper::contains('no', 'theword'));
    }
    
    public function testArrayContains()
    {
        $this->assertTrue(StringHelper::contains(['foo', 'bar'], 'hello foo bar')); // disabled $strict mode
        $this->assertTrue(StringHelper::contains(['notexistings', 'bar'], 'hello bar foo')); // disabled $strict mode
        $this->assertTrue(StringHelper::contains(['bar', 'notexistings'], 'hello bar foo')); // disabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings'], 'hello bar foo'));
    }

    public function testArrayStrictContains()
    {
        $this->assertTrue(StringHelper::contains(['foo', 'bar'], 'hello foo bar', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings', 'bar'], 'hello bar foo', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['bar', 'notexistings'], 'hello bar foo', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings'], 'hello bar foo', true)); // enabled strict mode
        $this->assertTrue(StringHelper::contains(['a', 'b', 'c'], 'thesmallabc', true));
    }
    
    public function testStartsWithWildcard()
    {
        $this->assertFalse(StringHelper::startsWithWildcard('abcdefgh', 'abc'));
        $this->assertTrue(StringHelper::startsWithWildcard('abcdefgh', 'abc*'));
        $this->assertFalse(StringHelper::startsWithWildcard('ABCDEFGHI', 'abc*'));
        $this->assertTrue(StringHelper::startsWithWildcard('ABCDEFGHI', 'abc*', false));
    }
}
