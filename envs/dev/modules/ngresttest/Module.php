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
        return (new AdminMenuBuilder($this))->node('Table', 'extension') // instead of extension, choose icon from https://design.google.com/icons/
            ->group('GROUP')
                ->itemApi('Table', 'ngresttest-table-index', 'label', 'api-ngresttest-table');
    }
}