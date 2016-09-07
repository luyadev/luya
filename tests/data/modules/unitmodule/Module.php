<?php

namespace luyatests\data\modules\unitmodule;

use luyatests\data\modules\unitmodule\components\FooComponent;
use luya\base\CoreModuleInterface;

class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $useAppViewPath = true;
    
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
