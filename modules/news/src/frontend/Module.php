<?php

namespace luya\news\frontend;

/**
 * CMS Module
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\base\Module
{
    /**
     * @var boolean use the application view folder
     */
    public $useAppViewPath = true;
    
    /**
     * @var boolean Is core module makes it inlist invisible
     */
    public $isCoreModule = true;

    /**
     * @var array
     */
    public $urlRules = [
        ['pattern' => 'news/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}
