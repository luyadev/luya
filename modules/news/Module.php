<?php

namespace news;

class Module extends \luya\base\Module
{
    public static $urlRules = [
        ['pattern' => 'news/detail/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}
