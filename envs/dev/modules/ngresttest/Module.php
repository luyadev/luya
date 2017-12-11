<?php

namespace ngresttest;

class Module extends \luya\admin\base\Module
{
    public $apis = [
            'api-ngresttest-table' => 'ngresttest\apis\TableController',
            'api-ngresttest-order' => 'ngresttest\apis\OrderController',
            'api-ngresttest-customer' => 'ngresttest\apis\CustomerController',
            
        'api-ngresttest-event' => 'ngresttest\apis\EventController',
        'api-ngresttest-price' => 'ngresttest\apis\PriceController',
        'api-ngresttest-category' => 'ngresttest\apis\CategoryController',
        
    ];
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('Table', 'extension')
        ->group('Group1')
        ->itemApi('Table', 'ngresttestadmin/table/index', 'label', 'api-ngresttest-table')
        
        ->group('Group2')
        ->itemApi('Order', 'ngresttestadmin/order/index', 'label', 'api-ngresttest-order')
        ->itemApi('Customer', 'ngresttestadmin/customer/index', 'label', 'api-ngresttest-customer')
        
        ->group('Junction Table Example')
        ->itemApi('Event', 'ngresttestadmin/event/index', 'label', 'api-ngresttest-event')
        ->itemApi('Price', 'ngresttestadmin/price/index', 'label', 'api-ngresttest-price')
        ->itemApi('Category', 'ngresttestadmin/category/index', 'label', 'api-ngresttest-category');
    }
}
