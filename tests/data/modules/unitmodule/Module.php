<?php

namespace tests\data\modules\unitmodule;

use tests\data\modules\unitmodule\components\FooComponent;
class Module extends \luya\base\Module
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
