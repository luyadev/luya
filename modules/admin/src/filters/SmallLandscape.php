<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Small Landscape (150x50)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SmallLandscape extends \admin\base\Filter
{
    public function identifier()
    {
        return 'small-landscape';
    }

    public function name()
    {
        return 'Landscape small (150x50)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 150,
                'height' => 50,
            ]],
        ];
    }
}
