<?php

namespace luya\admin\filters;

use luya\admin\base\Filter;

/**
 * Admin Module default Filter: Large Thumbanil (800xnull)
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LargeThumbnail extends Filter
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
