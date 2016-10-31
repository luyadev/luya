<?php

namespace ngresttest;

use luya\admin\components\AdminMenuBuilder;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-ngresttest-myadminuser' => 'ngresttest\apis\MyAdminUserController',
    ];
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('MyAdminUser', 'extension')
        ->group('Group')
        ->itemApi('MyAdminUser', 'ngresttest/my-admin-user/index', 'label', 'api-ngresttest-myadminuser');
    }
    
}