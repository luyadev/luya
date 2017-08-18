<?php

namespace ngresttest;

class Module extends \luya\admin\base\Module
{
    public $apis = [
            'api-ngresttest-table' => 'ngresttest\apis\TableController',
            'api-ngresttest-order' => 'ngresttest\apis\OrderController',
            'api-ngresttest-customer' => 'ngresttest\apis\CustomerController',
            
    ];
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('Table', 'extension')
        ->group('Group')
        ->itemApi('Table', 'ngresttest/table/index', 'label', 'api-ngresttest-table')
        
        ->group('Group')
        ->itemApi('Order', 'ngresttest/order/index', 'label', 'api-ngresttest-order')
        ->itemApi('Customer', 'ngresttest/customer/index', 'label', 'api-ngresttest-customer');
    }
}
