<?php

namespace luya\admin\filters;

use luya\admin\base\Filter;

/**
 * Admin Module default Filter: Medium Thumbnail (300xnull)
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MediumThumbnail extends Filter
{
    public static function identifier()
    {
        return 'medium-thumbnail';
    }

    public function name()
    {
        return 'Thumbnail medium (300xnull)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 300,
                'height' => null,
            ]],
        ];
    }
}
