<?php

namespace luya\cms\helpers;

use luya\TagParser as BaseTagParser;

trigger_error("TagParser of CMS is deprecated, use luya\TagParser instead.", E_USER_DEPRECATED);

class TagParser
{
    public static function convert($text)
    {
        return BaseTagParser::convert($text);
    }
    
    public static function convertWithMarkdown($text)
    {
        return BaseTagParser::convertWithMarkdown($text);
    }
}