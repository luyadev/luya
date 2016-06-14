<?php

namespace admin\filters;

class LargeThumbnail extends \admin\base\Filter
{
    public function identifier()
    {
        return 'large-thumbnail';
    }

    public function name()
    {
        return 'Thumbnail gross (800x800)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 800,
                'height' => null,
            ]],
        ];
    }
}
