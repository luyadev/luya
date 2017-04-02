<?php

namespace app\filters;

use luya\admin\base\Filter;
use Imagine\Image\ManipulatorInterface;

class TestFilter extends Filter
{
    public static function identifier()
    {
        return 'test-filter';
    }
    
    public function name()
    {
        return 'Test Filter';
    }
    
    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, ['width' => 150, 'height' => 70, 'mode' => ManipulatorInterface::THUMBNAIL_OUTBOUND, 'saveOptions' => ['quality' => 80]]],
            //[self::EFFECT_CROP, ['width' => 100, 'height' => 100]],
        ];
    }
}
