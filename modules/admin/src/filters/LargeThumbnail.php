<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Large Thumbanil (800xnull)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LargeThumbnail extends \admin\base\Filter
{
    public static function identifier()
    {
        return 'large-thumbnail';
    }

    public function name()
    {
        return 'Thumbnail large (800xnull)';
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
