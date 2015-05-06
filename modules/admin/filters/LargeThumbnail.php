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
        return 'grosses Thumbnail';
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
