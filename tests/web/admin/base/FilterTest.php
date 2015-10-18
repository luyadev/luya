<?php

namespace tests\web\admin\base;

use admin\base\Filter;

class MyFilter extends Filter
{
    public function identifier()
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
                'width' => 100,
                'height' => 100,
            ]],
        ];
    }
}

class FilterTest extends \tests\web\Base
{
    public function testBase()
    {
        $filter = new MyFilter();
        $this->assertEquals(true, is_object($filter->findModel()));
        $this->assertEquals(true, is_array($filter->findEffect($filter::EFFECT_RESIZE)));
        $this->assertEquals(true, is_array($filter->getChain()));
    }
}