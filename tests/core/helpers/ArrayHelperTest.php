<?php

namespace luyatests\core\helpers;

use luyatests\LuyaWebTestCase;
use luya\helpers\ArrayHelper;

class ArrayHelperTest extends LuyaWebTestCase
{
    public function testToObject()
    {
        $this->assertTrue(is_object(ArrayHelper::toObject(['foo' => 'bar'])));
        $this->assertEquals('bar', ArrayHelper::toObject(['foo' => 'bar'])->foo);
    }
    
    public function testUnshiftAssoc()
    {
        $arr = ['foo' => 'bar', 'nokey'];
        $unshift = ArrayHelper::arrayUnshiftAssoc($arr, 'before', 'the-value');
        $this->assertEquals(3, count($unshift));
        $i = 0;
        foreach ($unshift as $k => $v) {
            if ($i == 0) {
                $this->assertEquals('the-value', $unshift[$k]);
            }
            $i++;
        }
    }

    public function testTypeCast()
    {
        $array = [
            1 => 1,
            '2' => '2',
            "3" => "3",
            "4" => "string",
            'sub' => [
                1 => 1,
                2 => '2',
                3 => '3',
                4 => 'string',
            ],
        ];
        
        $typecasted = ArrayHelper::typeCast($array);
        
        $this->assertSame(1, $typecasted[1]);
        $this->assertSame(2, $typecasted[2]);
        $this->assertSame(3, $typecasted[3]);
        $this->assertSame('string', $typecasted[4]);
        
        $this->assertSame(1, $typecasted['sub'][1]);
        $this->assertSame(2, $typecasted['sub'][2]);
        $this->assertSame(3, $typecasted['sub'][3]);
        $this->assertSame('string', $typecasted['sub'][4]);
    }
}
