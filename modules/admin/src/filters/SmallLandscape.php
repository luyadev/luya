<?php

namespace admin\filters;

class SmallLandscape extends \admin\base\Filter
{
    public function identifier()
    {
        return 'small-landscape';
    }

    public function name()
    {
        return 'Kleines Landschaftsbild (150x50)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 150,
                'height' => 150,
                'type' => \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND,
            ]],
            [self::EFFECT_CROP, [
                'width' => 150,
                'height' => 50,
            ]],
        ];
    }
}
