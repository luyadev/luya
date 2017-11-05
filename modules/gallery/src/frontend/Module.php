<?php

namespace luya\gallery\frontend;

/**
 * Gallery Frontend Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\base\Module
{
    /**
     * @var boolean This module does not have view files, so the view are looked up in the application folder.
     */
    public $useAppViewPath = true;

    /**
     * @inheritdoc
     */
    public $urlRules = [
        ['pattern' => 'gallery/kategorie/<catId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/alben/index'],
        ['pattern' => 'gallery/album/<albumId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/album/index'],
    ];

    /**
     * @var string Default route for this module: controller/action
     */
    public $defaultRoute = 'cat';
}
