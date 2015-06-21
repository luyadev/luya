<?php

namespace admin\filters;

class TinyCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'tiny-crop';
    }
    
    public function name()
    {
        return 'Zuschneiden sehr klein (40x40)';
    }
    
    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 40,
                'height' => 40,
                'type' => \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
            ]],
            [self::EFFECT_CROP, [
                'width' => 40,
                'height' => 40,
            ]],
        ];
    }
}