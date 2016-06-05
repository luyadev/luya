<?php

namespace gallery;

/**
 * Gallery Module
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\base\Module
{
	/**
	 * @var boolean This module does not have view files, so the view are looked up in the application folder.
	 */
    public $useAppViewPath = true;
    
    /**
     * @var boolean This module will be hidden from several selections.
     */
    public $isCoreModule = true;

    public $urlRules = [
        ['pattern' => 'gallery/kategorie/<catId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/alben/index'],
        ['pattern' => 'gallery/album/<albumId:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'gallery/album/index'],
    ];

    /**
     * @var string Default route for this module: controller/action
     */
    public $defaultRoute = 'cat';
}
