<?php

namespace admin\filters;

class SmallThumbnail extends \admin\base\Filter
{
    public function identifier()
    {
        return 'small-thumbnail';
    }

    public function name()
    {
        return 'kleines Thumbnail';
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
