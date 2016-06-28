<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Large Crop (800x800)
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LargeCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'large-crop';
    }

    public function name()
    {
        return 'Crop large (800x800)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 800,
                'height' => 800,
            ]],
        ];
    }
}
