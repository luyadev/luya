<?php

namespace tests\admin\base;

use luya\admin\base\Filter;
use admintests\AdminTestCase;

class MyFilter extends Filter
{
    public static function identifier()
    {
        return 'my-test-filter';
    }

    public function name()
    {
        return 'Mein Test Filter';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 200,
                'height' => 100,
            ]],
            [self::EFFECT_CROP, [
                'width' => 200,
                'height' => 100,
            ]],
        ];
    }
}

class FilterTest extends AdminTestCase
{
    public function testBase()
    {
        $filter = new MyFilter();
        $this->assertEquals(true, is_object($filter));
        // comment out as it requers databse
        //$this->assertEquals(true, is_object($filter->findModel()));
        //$this->assertEquals(true, is_array($filter->findEffect($filter::EFFECT_RESIZE)));
        //$chain = $filter->getChain();
        //$this->assertEquals(true, is_array($chain));
        //$this->arrayHasKey('effect_id', $chain[0]);
        //$this->arrayHasKey('effect_json_values', $chain[0]);
    }
}
