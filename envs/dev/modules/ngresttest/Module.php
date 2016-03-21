<?php

namespace ngresttest;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-ngresttest-table' => 'ngresttest\apis\TableController',
    ];
    
    public function getMenu()
    {
        return $this->node('Table', 'extension') // instead of extension, choose icon from https://design.google.com/icons/
            ->group('GROUP')
                ->itemApi('Table', 'ngresttest-table-index', 'label', 'api-ngresttest-table') // instead of label, choose icon from https://design.google.com/icons/
        ->menu();
    }
}