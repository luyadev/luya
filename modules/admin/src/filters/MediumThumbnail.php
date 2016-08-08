<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Medium Thumbnail (300xnull)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class MediumThumbnail extends \admin\base\Filter
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
