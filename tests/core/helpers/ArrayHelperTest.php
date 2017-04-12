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
                5 => '1',
                6 => '-1',
                7 => '1.5',
                8 => '-1.5',
            ],
            'float' => 27.25,
            'integerfloatstring' => '27.25',
            'minus1' => -1,
            'minus1float' => -1.5,
            'minus1string' => '-1',
            'minus1stringfloat' => '-1.5',
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
        $this->assertSame(1, $typecasted['sub'][5]);
        $this->assertSame(-1, $typecasted['sub'][6]);
        $this->assertSame(1.5, $typecasted['sub'][7]);
        $this->assertSame(-1.5, $typecasted['sub'][8]);
        
        $this->assertSame(27.25, $typecasted['float']);
        $this->assertSame(27.25, $typecasted['integerfloatstring']);
        $this->assertSame(-1, $typecasted['minus1']);
        $this->assertSame(-1.5, $typecasted['minus1float']);
        $this->assertSame(-1, $typecasted['minus1string']);
        $this->assertSame(-1.5, $typecasted['minus1stringfloat']);
    }
    
    public function testSearch()
    {
        $data = [
            [
                'name' => 'Foo Bar',
                'description' => 'same',
                'id' => 1,
            ],
            [
                'name' => 'Baz foo',
                'description' => 'same',
                'id' => 2,
            ]
        ];
        
        $this->assertSame(1, count(ArrayHelper::search($data, '1')));
        $this->assertSame(1, count(ArrayHelper::search($data, 1)));
        $this->assertSame(2, count(ArrayHelper::search($data, 'FOO')));
        $this->assertSame(2, count(ArrayHelper::search($data, 'foo')));
        $this->assertSame(2, count(ArrayHelper::search($data, 'Foo')));
        $this->assertSame(2, count(ArrayHelper::search($data, 'fo')));
        
        $this->assertSame(1, count(ArrayHelper::search($data, 'Foo', true)));
    }
    
    public function testSearchColumn()
    {
        $array = [
            ['foo' => 'bar'],
            ['foo' => 'baz'],
        ];
        
        $this->assertSame(['foo' => 'bar'], ArrayHelper::searchColumn($array, 'foo', 'bar'));
        $this->assertFalse(ArrayHelper::searchColumn($array, 'foo', 'ba'));
        
        $sameResults = [
            ['foo' => 'bar', 'prio' => 1],
            ['foo' => 'bar', 'prio' => 2],
        ];
        
        $this->assertSame(['foo' => 'bar', 'prio' => 1], ArrayHelper::searchColumn($sameResults, 'foo', 'bar'));
    }
    
    public function testSearchColumns()
    {
        $array = [
            ['foo' => 'bar', 'user_id' => 1],
            'key' => ['foo' => 'baz', 'user_id' => 1],
        ];
        
        $this->assertSame([
            ['foo' => 'bar', 'user_id' => 1],
            'key' => ['foo' => 'baz', 'user_id' => 1],
        ], ArrayHelper::searchColumns($array, 'user_id', 1));
        
        $this->assertSame([
            'key' => ['foo' => 'baz', 'user_id' => 1],
        ], ArrayHelper::searchColumns($array, 'foo', 'baz'));
        
        $this->assertSame([
            'key' => ['foo' => 'baz', 'user_id' => 1],
        ], ArrayHelper::searchColumns($array, 'foo', 'BAZ'));
        
        
        $this->assertSame([], ArrayHelper::searchColumns($array, 'foo', 'NOTFOUNDATALL'));
    }
}
