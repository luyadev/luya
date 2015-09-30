<?php

namespace gallery;

class Module extends \luya\base\Module
{
    public $isCoreModule = true;
    
    public $urlRules = [
        ['pattern' => 'gallery/kategorie/<catId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/alben/index'],
        ['pattern' => 'gallery/album/<albumId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/album/index'],
    ];

    public $defaultRoute = 'cat';
}
