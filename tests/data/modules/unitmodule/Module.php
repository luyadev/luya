<?php

namespace luyatests\data\modules\unitmodule;

use luya\base\CoreModuleInterface;
use luyatests\data\modules\unitmodule\components\FooComponent;

class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $useAppViewPath = true;

    // Map all viewmap actions to viewmodule
    public $viewMap = [
        'viewmap/viewmap3' =>   '@luyatests/data/modules/viewmodule/views/stub',
        'viewmap/*' =>          '@luyatests/data/modules/viewmodule/views/viewmap',
        '*' =>                  '@luyatests/data/modules/viewmodule/views',
    ];

    public $defaultRoute = 'test';

    public function registerComponents()
    {
        return [
            'foo' => [
                'class' => FooComponent::className(),
            ],
        ];
    }
}
