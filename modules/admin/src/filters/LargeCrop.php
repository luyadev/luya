<?php

namespace admin\filters;

class LargeCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'large-crop';
    }

    public function name()
    {
        return 'Zuschneiden gross (800x800)';
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
