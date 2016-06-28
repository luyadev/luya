<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Small Crop (100x100)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SmallCrop extends \admin\base\Filter
{
    public function identifier()
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
