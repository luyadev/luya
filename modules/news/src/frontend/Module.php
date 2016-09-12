<?php

namespace luya\news\frontend;

use luya\base\CoreModuleInterface;

/**
 * CMS Module
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\base\Module implements CoreModuleInterface
{
    /**
     * @var boolean use the application view folder
     */
    public $useAppViewPath = true;

    /**
     * @var array
     */
    public $urlRules = [
        ['pattern' => 'news/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}
