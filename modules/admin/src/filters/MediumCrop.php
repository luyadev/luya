<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Medium Crop (300x300)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class MediumCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'medium-crop';
    }

    public function name()
    {
        return 'Crop medium (300x300)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 300,
                'height' => 300,
            ]],
        ];
    }
}
