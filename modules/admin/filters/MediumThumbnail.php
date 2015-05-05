<?php

namespace admin\filters;

class MediumThumbnail extends \admin\base\Filter
{    
    public function identifier()
    {
        return 'medium-thumbnail';
    }
    
    public function name()
    {
        return 'mittleres Thumbnail';
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