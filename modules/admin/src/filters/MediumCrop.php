<?php

namespace admin\filters;

class MediumCrop extends \admin\base\Filter
{
    public function identifier()
    {
        return 'medium-crop';
    }

    public function name()
    {
        return 'Zuschneiden mittel (300x300)';
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
