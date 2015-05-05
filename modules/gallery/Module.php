<?php

namespace gallery;

class Module extends \luya\base\Module
{
    public static $urlRules = [
        ['pattern' => 'gallery/album/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/default/detail']
    ];
}