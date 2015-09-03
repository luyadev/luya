<?php

namespace tests\data\modules\urlmodule;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'urlmodule/bar', 'route' => 'urlmodule/bar/index'],
    ];
}
