<?php

namespace admin\filters;

/**
 * Admin Module default Filter: Small Thumbail (100xnull)
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SmallThumbnail extends \admin\base\Filter
{
    public function identifier()
    {
        return 'small-thumbnail';
    }

    public function name()
    {
        return 'Thumbnail small (100xnull)';
    }

    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 100,
                'height' => null,
            ]],
        ];
    }
}
