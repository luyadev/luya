<?php

namespace luya\admin\filters;

use luya\admin\base\Filter;

/**
 * Admin Module default Filter: Small Crop (100x100)
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SmallCrop extends Filter
{
    public static function identifier()
    {
        return 'small-crop';
    }

    public function name()
    {
        return 'Crop small (100x100)';
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
