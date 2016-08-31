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
}
