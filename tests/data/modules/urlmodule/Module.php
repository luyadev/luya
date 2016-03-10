<?php

namespace luyatests\data\modules\urlmodule;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'urlmodule/bar', 'route' => 'urlmodule/bar/index'],
        ['pattern' => 'urlmodule', 'route' => 'urlmodule/default/index'],
    ];
}
