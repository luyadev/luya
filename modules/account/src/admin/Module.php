<?php

namespace luya\account\admin;

use luya\admin\components\AdminMenuBuilder;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-account-user' => 'luya\account\admin\apis\UserController',
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
        ->node('Accounts', 'supervisor_account')
            ->group('Übersicht')
                ->itemApi('Benutzer', 'accountadmin/user/index', 'account_circle', 'api-account-user');
    }
}
