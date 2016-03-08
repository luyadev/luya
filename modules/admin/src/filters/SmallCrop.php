<?php

namespace admin\filters;

class SmallCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'small-crop';
    }

    public function name()
    {
        return 'Zuschneiden klein (100x100)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 100,
                'height' => 100,
                'type' => \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND,
            ]],
            [self::EFFECT_CROP, [
                'width' => 100,
                'height' => 100,
            ]],
        ];
    }
}
