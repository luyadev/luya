<?php

namespace admin\filters;

class TinyThumbnail extends \admin\base\Filter
{
    public function identifier()
    {
        return 'tiny-thumbnail';
    }

    public function name()
    {
        return 'Thumbnail klein (40x40)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 40,
                'height' => 40,
            ]],
        ];
    }
}
