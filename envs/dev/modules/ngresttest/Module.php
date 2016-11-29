<?php

namespace ngresttest;

use luya\admin\components\AdminMenuBuilder;

class Module extends \luya\admin\base\Module
{
    public $apis = [
            'api-ngresttest-table' => 'ngresttest\apis\TableController',
    ];
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('Table', 'extension')
        ->group('Group')
        ->itemApi('Table', 'ngresttest/table/index', 'label', 'api-ngresttest-table');
    }
}
